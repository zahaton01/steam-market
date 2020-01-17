<?php

namespace App\Command;

use App\Exception\Steam\SteamRequestFailed;
use App\Factory\CSGOItemBuyDecisionFactory;
use App\Manager\BaseManager;
use App\Model\Steam\CSGO\SteamCSGOItem;
use App\Service\CalculationService;
use App\Service\DecisionMaker;
use App\Service\Proxy\ProxyService;
use App\Service\ProxyGrabber;
use App\Service\Steam\SteamMarketplace;
use App\Service\TMMarketplace\TMCSGOMarketplace;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MonitorCSGOPricesCommand extends AbstractCommand
{
    /** @var SteamMarketplace  */
    private $steamMarketplace;
    /** @var TMCSGOMarketplace  */
    private $TMMarketplace;
    /** @var CalculationService */
    private $calculation;
    /** @var DecisionMaker */
    private $decisionMaker;
    /** @var CSGOItemBuyDecisionFactory */
    private $decisionFactory;
    /** @var BaseManager */
    private $manager;
    /** @var ProxyService */
    private $proxy;

    /**
     * MonitorCSGOPricesCommand constructor.
     * @param SteamMarketplace $steamMarketplace
     * @param TMCSGOMarketplace $TMCSGOMarketplace
     * @param CalculationService $calculation
     * @param DecisionMaker $decisionMaker
     * @param CSGOItemBuyDecisionFactory $factory
     * @param BaseManager $manager
     * @param ProxyService $proxy
     */
    public function __construct(
        SteamMarketplace $steamMarketplace,
        TMCSGOMarketplace $TMCSGOMarketplace,
        CalculationService $calculation,
        DecisionMaker $decisionMaker,
        CSGOItemBuyDecisionFactory $factory,
        BaseManager $manager,
        ProxyService $proxy
    ) {
        parent::__construct();
        $this->steamMarketplace = $steamMarketplace;
        $this->TMMarketplace = $TMCSGOMarketplace;
        $this->calculation = $calculation;
        $this->decisionMaker = $decisionMaker;
        $this->decisionFactory = $factory;
        $this->manager = $manager;
        $this->proxy = $proxy;
    }

    protected function configure()
    {
        $this
            ->setName('prices:monitor:cs-go')
            ->setDescription('Monitor current prices of all available items');
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
        $output->writeln('Starting...');
        $output->writeln('Grabbing proxies...');

        $proxies = $this->proxy->getGrabber()->fromInternalApi();
        $output->writeln("Grabbed " . count($proxies) . ' proxies');

        $this->steamMarketplace->setProxies($proxies);
        $currentPrices = $this->TMMarketplace->retrieveCurrentPrices();
        $output->writeln('Retrieved data from TM marketplace');
        $this->space($output);

        /**
         * @var string $index
         * @var SteamCSGOItem $item
         */
        foreach ($currentPrices as $index => $item) {
            try {
                if ($index % 3 === 0 && $index > 0) {
                    $this->comment($output,'Three items passed. Sleeping twenty seconds');
                    sleep(10);
                }

                $output->writeln('Getting steam item...');
                $steamEquivalent = $this->steamMarketplace->getCsGoItemMetaData($item->getHashName());
                $realPrice = $this->calculation->getCSGOItemRealPrice($steamEquivalent);

                $output->writeln("<info>Item: {$item->getHashName()}</info>");
                $output->writeln("Market price: {$item->getPrice()}");
                $output->writeln("Steam price: {$steamEquivalent->getLowestPrice()}");
                $output->writeln("Steam real price: {$realPrice}");

                if ($realPrice > $item->getPrice()) { // The item probably fits us in price
                    $instance = $this->TMMarketplace->retrieveInstance($item->getHashName());
                    $decisionEntity = $this->decisionFactory->createFromItemAndInstance($steamEquivalent, $instance);

                    $output->writeln('<info>This item is probably fine. Making decision...</info>');
                    $decision = $this->decisionMaker->shallWeBuyThisCSGOItem($steamEquivalent, $instance);
                    $decisionEntity
                        ->setMinSellPrice($decision->getMinSellPrice())
                        ->setDecision($decision);

                    $this->manager->save($decisionEntity);

                    if ($decision->isApproved()) {
                        $output->writeln('Item is approved for buying');
                    } else {
                        $output->writeln('Item is declined for buying');
                    }
                }

                $this->space($output);

                sleep(3);
            } catch (SteamRequestFailed $e) {
                $this->error($output,"Steam request failed to item: {$item->getHashName()}; <br> {$e->getMessage()}");
                $this->comment($output, 'Sleeping 30 seconds');

                sleep(30); // Sleeping because of too many requests
                continue;
            }
        }

        return 1;
    }
}
