<?php

namespace App\Application\Console\Command\Prices\Monitor\CS;

use App\Application\Config\ConfigResolver;
use App\Application\Config\Items\CS\CSItemsConfig;
use App\Application\Console\Command\Prices\AbstractPricesCommand;
use App\Application\Logs\DB\Console\ConsoleDBLogger;
use App\Application\Model\Currency;
use App\Application\Resources\API\TM\TMMarketplace;
use App\Application\Resources\ApiResourceResolver;
use App\Application\Tools\DecisionMaker\DecisionMaker;
use App\Application\Tools\DecisionMaker\Instances\CSInstance;
use App\Application\Tools\DecisionMaker\Makers\CSDecisionMaker;
use App\Domain\Entity\CS\CSItem;
use App\Domain\Entity\CS\Steam\AbstractSteamPrice;
use App\Domain\Entity\CS\Steam\Price\OneMonthSteamPrice;
use App\Domain\Entity\Queue\CSTMItemDecisionQueue;
use App\Domain\Factory\Decision\CSBuyingDecisionFactory;
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
    /** @var DecisionMaker */
    private $decisionMaker;

    private $factory;

    /**
     * TMPricesCommand constructor.
     * @param ConsoleDBLogger $logger
     * @param BaseManager $manager
     * @param ApiResourceResolver $apiResourceResolver
     * @param ConfigResolver $configResolver
     * @param DecisionMaker $decisionMaker
     *
     * @throws \Exception
     */
    public function __construct(
        ConsoleDBLogger $logger,
        BaseManager $manager,
        ApiResourceResolver $apiResourceResolver,
        ConfigResolver $configResolver,
        DecisionMaker $decisionMaker,
        CSBuyingDecisionFactory $factory
    ) {
        parent::__construct($logger, $manager);

        $this->resources = $apiResourceResolver;
        $this->config = $configResolver->resolve(CSItemsConfig::class);
        $this->decisionMaker = $decisionMaker;
        $this->factory = $factory;
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
                        if (!$this->inCSTMDecisionQueue($relevantItem->getHashName())) {
                            try {
                                $this->info("Adding {$relevantItem->getHashName()} to decision queue");

                                $queue = new CSTMItemDecisionQueue();
                                $queue->setHashName($relevantItem->getHashName());
                                $this->manager->save($queue); // If we have such record in db this item wont be added to queue until it is consumed

                                $this->decisionMaker->getInstance(CSInstance::class)->trigger($relevantItem->getHashName());
                            } catch (\Exception $e) {
                                $this->error($e->getMessage());
                            }
                        }
                    }
                }
            }
        }

        return 1;
    }
}
