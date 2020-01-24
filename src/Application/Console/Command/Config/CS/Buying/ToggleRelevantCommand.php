<?php

namespace App\Application\Console\Command\Config\CS\Buying;

use App\Application\Config\ConfigResolver;
use App\Application\Config\Items\CS\CSItemsConfig;
use App\Application\Console\Command\Config\AbstractConfigCommand;
use App\Application\Exception\Config\ConfigInvokeFailed;
use App\Application\Exception\Config\ConfigNotFound;
use App\Application\Logs\DB\Console\ConsoleDBLogger;
use App\Application\Model\Currency;
use App\Application\Resources\API\BP\BPResource;
use App\Application\Resources\API\BP\Proto\ItemList\ItemListProto;
use App\Application\Resources\API\BP\Proto\ItemList\Model\Item;
use App\Application\Resources\ApiResourceResolver;
use App\Domain\Entity\CS\CSItem;
use App\Domain\Manager\BaseManager;
use App\Domain\Tool\Pagination\Pagination;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class ToggleRelevantCommand extends AbstractConfigCommand
{
    /** @var ApiResourceResolver */
    private $resources;
    /** @var array */
    private $bannedTags;

    /**
     * ToggleRelevantCommand constructor.
     * @param ConsoleDBLogger $logger
     * @param BaseManager $manager
     * @param ConfigResolver $config
     * @param ApiResourceResolver $resources
     *
     * @throws ConfigInvokeFailed
     * @throws ConfigNotFound
     */
    public function __construct(ConsoleDBLogger $logger, BaseManager $manager, ConfigResolver $config, ApiResourceResolver $resources)
    {
        parent::__construct($logger, $manager, $config);

        $this->resources = $resources;

        /** @var CSItemsConfig $config */
        $config = $this->config->resolve(CSItemsConfig::class);
        $this->bannedTags = $config->getBannedForBuying()['banned_for_buying'];
    }

    protected function configure()
    {
        $this
            ->setName('config:buying:cs:toggle-relevant')
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

        $pagination = new Pagination(1, 1); // faking page size to retrieve total count
        /** @var CSItem[] $items */
        $items = $this->manager->getEntityManager()->getRepository(CSItem::class)->getAllItems($pagination);
        /** @var ItemListProto $itemList */
        $itemList = $this->resources->resolve(BPResource::class)->getItemList(Currency::RUB);
        $pagination->setTotalItems(count($items));
        $pagination->setPageSize(5000);

        for ($i = 1; $i <= $pagination->getTotalPages(); $i++) {
            $pagination->setPage($i);

            /** @var CSItem[] $items */
            $items = $this->manager->getEntityManager()->getRepository(CSItem::class)->getAllItems($pagination);

            foreach ($items as $item) {
                $this->info("Checking {$item->getHashName()}");

                if (!$this->bannedTags($item->getHashName())) {
                    $this->comment("Disabling because of censor");

                    $item->setIsAllowedForBuying(false);
                    $this->manager->getEntityManager()->persist($item);
                    continue;
                }

                $minPrice = (float) $_ENV['ITEM_MIN_BUY'];
                $maxPrice = (float) $_ENV['ITEM_MAX_BUY'];

                $price = 0;
                /** @var Item $itemProto */
                foreach ($itemList->getItems() as $index => $itemProto) {
                    if ($itemProto->getHashName() === $item->getHashName()) {
                        $price = $itemProto->getWeekPrice() ? $itemProto->getWeekPrice()->getAverage() : 0;
                        unset($itemList->getItems()[$index]); // reducing array size for followed loops
                    }
                }

                if ($price < $minPrice || $price > $maxPrice) {
                    $this->comment("Disabling because of price");

                    $item->setIsAllowedForBuying(false);
                    $this->manager->getEntityManager()->persist($item);
                    continue;
                }

                $this->info('Leaving enabled');
                $item->setIsAllowedForBuying(true);
                $this->manager->getEntityManager()->persist($item);
            }

            $this->manager->getEntityManager()->flush();
            $this->manager->getEntityManager()->clear();
        }

        $this->comment("Finished. Execution time: {$this->getExecutionTime()} seconds");
        return 1;
    }

    /**
     * @param string $hashName
     *
     * @return bool
     */
    private function bannedTags(string $hashName)
    {
        foreach ($this->bannedTags['exclude'] as $exclude) {
            if (strpos($hashName, $exclude) !== false) {
                return true;
            }
        }

        foreach ($this->bannedTags['tags'] as $tag) {
            if (strpos($hashName, $tag) !== false) {
                return false;
            }
        }

        return true;
    }
}
