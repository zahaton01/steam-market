<?php

namespace App\Application\Console\Command\Prices\Grabber\CS;

use App\Application\Console\Command\Prices\AbstractPricesCommand;
use App\Application\Logs\DB\Console\ConsoleDBLogger;
use App\Application\Model\Currency;
use App\Application\Resources\API\BP\BPResource;
use App\Application\Resources\ApiResourceResolver;
use App\Domain\Entity\CS\CSItem;
use App\Domain\Factory\CS\CSFactoryResolver;
use App\Domain\Factory\CS\Price\OneDaySteamPriceFactory;
use App\Domain\Factory\CS\Price\OneMonthSteamPriceFactory;
use App\Domain\Factory\CS\Price\OneWeekSteamPriceFactory;
use App\Domain\Manager\BaseManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class BPSteamPriceGrabberCommand extends AbstractPricesCommand
{
    /** @var ApiResourceResolver  */
    private $resources;
    /** @var CSFactoryResolver */
    private $factories;

    /**
     * TMPricesCommand constructor.
     * @param ConsoleDBLogger $logger
     * @param BaseManager $manager
     * @param ApiResourceResolver $apiResourceResolver
     * @param CSFactoryResolver $factories
     *
     * @throws \Exception
     */
    public function __construct(
        ConsoleDBLogger $logger,
        BaseManager $manager,
        ApiResourceResolver $apiResourceResolver,
        CSFactoryResolver $factories
    ) {
        parent::__construct($logger, $manager);

        $this->resources = $apiResourceResolver;
        $this->factories = $factories;
    }

    protected function configure()
    {
        $this
            ->setName('prices:grabber:cs:bp')
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

        /** @var BPResource $bp */
        $bp = $this->resources->resolve(BPResource::class);

        /** @var OneDaySteamPriceFactory $oneDayFactory */
        $oneDayFactory = $this->factories->resolve(OneDaySteamPriceFactory::class);
        /** @var OneWeekSteamPriceFactory $oneWeekFactory */
        $oneWeekFactory = $this->factories->resolve(OneWeekSteamPriceFactory::class);
        /** @var OneMonthSteamPriceFactory $oneMonthFactory */
        $oneMonthFactory = $this->factories->resolve(OneMonthSteamPriceFactory::class);

        $this->info('Getting items from CSGOBackpack...');
        $items = $bp->getItemList(Currency::RUB);
        /** @var CSItem[] $relevantItems */
        $relevantItems = $this->manager->getEntityManager()->getRepository(CSItem::class)->getRelevant();

        foreach ($items->getItems() as $item) {
            foreach ($relevantItems as $relevantItem) { // creating prices only for relevant items
                if ($item->getHashName() === $relevantItem->getHashName()) {
                    $this->comment('Creating prices for ' . $item->getHashName());

                    if (null !== $item->getDayPrice()) {
                        $oneDayPrice = $oneDayFactory->createFromBP($item->getDayPrice(), $relevantItem, Currency::RUB);
                        $this->manager->getEntityManager()->persist($oneDayPrice);
                    }

                    if (null !== $item->getWeekPrice()) {
                        $oneWeekPrice = $oneWeekFactory->createFromBP($item->getWeekPrice(), $relevantItem, Currency::RUB);
                        $this->manager->getEntityManager()->persist($oneWeekPrice);
                    }

                    if (null !== $item->getMonthPrice()) {
                        $oneMonthPrice = $oneMonthFactory->createFromBP($item->getMonthPrice(), $relevantItem, Currency::RUB);
                        $this->manager->getEntityManager()->persist($oneMonthPrice);
                    }
                }
            }
        }

        $this->info('Saving to database...');
        $this->manager->getEntityManager()->flush();
        $this->info("Finished. Execution time {$this->getExecutionTime()} seconds");

        return 1;
    }
}