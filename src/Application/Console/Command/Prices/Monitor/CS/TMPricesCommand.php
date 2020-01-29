<?php

namespace App\Application\Console\Command\Prices\Monitor\CS;

use App\Application\Config\ConfigResolver;
use App\Application\Config\Items\CS\CSItemsConfig;
use App\Application\Console\Command\Prices\AbstractPricesCommand;
use App\Application\Logs\DB\Console\ConsoleDBLogger;
use App\Application\Model\Currency;
use App\Application\Resources\API\TM\TMMarketplace;
use App\Application\Resources\ApiResourceResolver;
use App\Domain\Entity\CS\CSItem;
use App\Domain\Entity\CS\Steam\AbstractSteamPrice;
use App\Domain\Entity\CS\Steam\Price\OneMonthSteamPrice;
use App\Domain\Manager\BaseManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class TMPricesCommand extends AbstractPricesCommand
{
    /** @var ApiResourceResolver  */
    private $resources;
    /** @var CSItemsConfig */
    private $config;

    /**
     * TMPricesCommand constructor.
     * @param ConsoleDBLogger $logger
     * @param BaseManager $manager
     * @param ApiResourceResolver $apiResourceResolver
     * @param ConfigResolver $configResolver
     *
     * @throws \Exception
     */
    public function __construct(
        ConsoleDBLogger $logger,
        BaseManager $manager,
        ApiResourceResolver $apiResourceResolver,
        ConfigResolver $configResolver
    ) {
        parent::__construct($logger, $manager);

        $this->resources = $apiResourceResolver;
        $this->config = $configResolver->resolve(CSItemsConfig::class);
    }

    protected function configure()
    {
        $this
            ->setName('prices:monitor:cs:tm')
            ->setDescription('Toggles items');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setOutput($output);
        /** @var TMMarketplace $tmMarket */
        $tmMarket = $this->resources->resolve(TMMarketplace::class);

        $this->info("Getting prices from TM Market");
        $prices = $tmMarket->getCsPrices(Currency::RUB);
        $this->info("Done... Monitoring...");
        /** @var CSItem[] $relevantItems */
        $relevantItems = $this->manager->getEntityManager()->getRepository(CSItem::class)->getRelevant();

        foreach ($prices->getPrices() as $price) {
            foreach ($relevantItems as $relevantItem) {
                if ($price->getHashName() === $relevantItem->getHashName()) {
                    /** @var AbstractSteamPrice $relevantItemPrice */
                    $relevantItemPrice = $this->manager->getEntityManager()->getRepository(OneMonthSteamPrice::class)
                            ->findBy(
                                ['item' => $relevantItem->getId()],
                                ['creationDate' => 'DESC'], 1)[0] ?? null;

                    if (null === $relevantItemPrice)
                        break;

                    if ($price->getPrice() <= ($relevantItemPrice->getMedian() * $this->config->getTriggerDecisionMakerPercentage())) {

                    }
                }
            }
        }

        return 1;
    }
}