<?php

namespace App\Command;

use App\Exception\Steam\SteamItemNotFound;
use App\Exception\Steam\SteamRequestFailed;
use App\Exception\TM\TMItemNotFound;
use App\Exception\TM\TMRequestFailed;
use App\Factory\CommandOutputFactory;
use App\Factory\CSGO\CSGOItemFactory;
use App\Factory\CSGO\CSGOItemSteamPriceFactory;
use App\Factory\CSGO\CSGOItemSteamSellHistoryFactory;
use App\Factory\CSGO\TMCSGOItemPriceHistoryFactory;
use App\Logs\CommandLogService;
use App\Manager\BaseManager;
use App\Model\Currency;
use App\Service\Exchange\Exchanger;
use App\Service\Steam\SteamMarketplace;
use App\Service\TMMarketplace\TMCSGOMarketplace;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GrabCSGOItemsCommand extends AbstractCommand
{
//    /** @var TMCSGOMarketplace */
//    private $TMMarketplace;
//    /** @var SteamMarketplace */
//    private $steamMarketplace;
//    /** @var CSGOItemFactory */
//    private $itemFactory;
//    /** @var CSGOItemSteamPriceFactory */
//    private $steamPriceFactory;
//    /** @var TMCSGOItemPriceHistoryFactory */
//    private $tmPriceHistoryFactory;
//    /** @var CSGOItemSteamSellHistoryFactory */
//    private $steamSellHistoryFactory;
//    /** @var EntityManagerInterface */
//    private $em;
//    /** @var Exchanger */
//    private $exchanger;
//
//    /**
//     * GrabCSGOItemsCommand constructor.
//     * @param TMCSGOMarketplace $marketplace
//     * @param CSGOItemFactory $itemFactory
//     * @param SteamMarketplace $steamMarketplace
//     * @param CSGOItemSteamPriceFactory $steamPriceFactory
//     * @param BaseManager $manager
//     * @param EntityManagerInterface $em
//     * @param TMCSGOItemPriceHistoryFactory $itemPriceHistoryFactory
//     * @param CommandLogService $logger
//     * @param CommandOutputFactory $commandOutputFactory
//     * @param CSGOItemSteamSellHistoryFactory $sellHistoryFactory
//     * @param Exchanger $exchanger
//     */
//    public function __construct(
//        //TMCSGOMarketplace $marketplace,
//        CSGOItemFactory $itemFactory,
//        SteamMarketplace $steamMarketplace,
//        CSGOItemSteamPriceFactory $steamPriceFactory,
//        BaseManager $manager,
//        EntityManagerInterface $em,
//        TMCSGOItemPriceHistoryFactory $itemPriceHistoryFactory,
//        CommandLogService $logger,
//        CommandOutputFactory $commandOutputFactory,
//        CSGOItemSteamSellHistoryFactory $sellHistoryFactory,
//        Exchanger $exchanger
//    ) {
//        parent::__construct($logger, $commandOutputFactory, $manager);
//        //$this->TMMarketplace = $marketplace;
//        $this->itemFactory = $itemFactory;
//        $this->steamMarketplace = $steamMarketplace;
//        $this->steamPriceFactory = $steamPriceFactory;
//        $this->em = $em;
//        $this->tmPriceHistoryFactory = $itemPriceHistoryFactory;
//        $this->steamSellHistoryFactory = $sellHistoryFactory;
//        $this->exchanger = $exchanger;
//    }
//
//    protected function configure()
//    {
//        $this
//            ->setName('cs-go:items:grab')
//            ->setDescription('Grabs CS GO items');
//    }
//
//    /**
//     * @param InputInterface $input
//     * @param OutputInterface $output
//     *
//     * @return int|void|null
//     *
//     * @throws \Exception
//     */
//    protected function execute(InputInterface $input, OutputInterface $output)
//    {
//        $this->setOutput($output);
//
//        $this->info('Getting instances from TMCSGOMarketplace...');
//        $instances = $this->TMMarketplace->retrieveCurrentInstances();
//        $this->info('Done');
//
//        $counter = 0;
//        foreach ($instances as $index => $instance) {
//            if ($this->isExist($instance->getHashName()))
//                continue;
//
//            if ($counter % 3 === 0) {
//                $this->spacedComment('Retrieved three items... Sleeping 10 seconds');
//                sleep(10);
//                $counter = 0;
//            }
//
//            try {
//                $this->info("Getting: {$instance->getHashName()} from steam...");
//                $steamItem = $this->steamMarketplace->getCsGoItemMetaData($instance->getHashName());
////                $steamSellHistory = $this->steamMarketplace->retrievePriceHistory($instance->getHashName());
//                $this->comment('Done');
//
//                $this->info("Getting: {$instance->getHashName()} from TMMarketplace...");
//                $tmDetails = $this->TMMarketplace->retrieveDetails($instance->getHashName());
//                $this->comment('Done');
//
//                $counter++;
//            } catch (SteamRequestFailed $e) {
//                $this->spacedError("Failed to retrieve {$instance->getHashName()} from steam", [
//                    'message' => $e->getMessage()
//                ]);
//                $this->comment('Sleeping 30 secs.');
//
//                sleep(30);
//                continue;
//            } catch (TMRequestFailed $e) {
//                $this->spacedError("Failed to retrieve details of item {$instance->getHashName()} from TMMarketplace", [
//                    'message' => $e->getMessage()
//                ]);
//
//                continue;
//            } catch (TMItemNotFound | SteamItemNotFound $e) {
//                $this->spacedError("Failed to retrieve {$instance->getHashName()} from steam", [
//                    'message' => $e->getMessage()
//                ]);
//
//                continue;
//            }
//
//            $item = $this->itemFactory->createFromInstance($instance);
//            $item->setSteamMarketplaceUrl($steamItem->getMarketplaceUrl());
//
//            $steamPrice = $this->steamPriceFactory->create(
//                $steamItem->getLowestPrice(),
//                $steamItem->getMedianPrice(),
//                $steamItem->getCurrency(),
//                $item
//            );
//
//            /**
//             * Steam session is needed for this api call.
//             * Not implemented
//             */
////            foreach ($steamSellHistory['prices'] as $sell) {
////                $history = $this->steamSellHistoryFactory->createFromJson($sell);
////
////                $price = $this->exchanger->from(Currency::UAH)->to(Currency::RUB)->amount($history->getPrice());
////                $history
////                    ->setCurrency(Currency::RUB)
////                    ->setPrice($price);
////
////                $item->addSteamSellHistory($history);
////            }
//
//            $item->addSteamPrice($steamPrice);
//
//            $tmPriceHistory = $this->tmPriceHistoryFactory->createFromDetails($tmDetails, $item);
//            $item->addTMPriceHistory($tmPriceHistory);
//
//            $this->manager->save($item);
//            $this->comment('Item grabbed');
//            $this->space();
//
//            sleep(3);
//        }
//
//        return 1;
//    }
//
//    /**
//     * @param string $hashName
//     *
//     * @return bool
//     */
//    private function isExist(string $hashName)
//    {
//        $item = $this->em->getRepository(CSGOItem::class)->findOneBy(['hashName' => $hashName]);
//
//        if (null === $item) {
//            return false;
//        }
//
//        return true;
//    }
}
