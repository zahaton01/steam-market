<?php

namespace App\Command\Config\Buying\CS;

use App\Entity\CS\CSItem;
use App\Factory\CommandOutputFactory;
use App\Logs\CommandLogService;
use App\Manager\BaseManager;
use App\Model\Pagination\Pagination;
use App\Proto\BP\ItemList\ItemListProto;
use App\Proto\BP\ItemList\ItemProto;
use App\Service\ResourceAPIs\BP\BPResource;
use App\Service\ResourceAPIs\Resolver\ResourceAPIsResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EnableRelevantCommand extends AbstractBuyingCommand
{
    /** @var EntityManagerInterface */
    private $em;
    /** @var ResourceAPIsResolver */
    private $resources;

    /**
     * DisableNotRelevantCommand constructor.
     * @param CommandLogService $logger
     * @param CommandOutputFactory $commandOutputFactory
     * @param BaseManager $manager
     * @param EntityManagerInterface $em
     * @param ResourceAPIsResolver $resourceAPIsResolver
     */
    public function __construct(
        CommandLogService $logger,
        CommandOutputFactory $commandOutputFactory,
        BaseManager $manager,
        EntityManagerInterface $em,
        ResourceAPIsResolver $resourceAPIsResolver
    ) {
        parent::__construct($logger, $commandOutputFactory, $manager);

        $this->em = $em;
        $this->resources = $resourceAPIsResolver;
    }

    protected function configure()
    {
        $this
            ->setName('config:buying:cs:enable-relevant')
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

        $pagination = new Pagination(100, 1);
        /** @var CSItem[] $items */
        $items = $this->em->getRepository(CSItem::class)->getAllItems($pagination, false);
        /** @var ItemListProto $itemList */
        $itemList = $this->resources->get(BPResource::class)->retrieveItems(strtoupper($_ENV['APP_CURRENCY']));
        $pagination->setTotalItems(count($items));

        for ($i = 1; $i <= $pagination->getTotalPages(); $i++) {
            $pagination->setPage($i);
            /** @var CSItem[] $items */
            $items = $this->em->getRepository(CSItem::class)->getAllItems($pagination, false);

            foreach ($items as $item) {
                $this->info("Checking {$item->getHashName()}");

                if (!$this->censor($item->getHashName())) {
                    $this->comment("Leaving disabled because of censor");
                    continue;
                }

                $minPrice = (float) $_ENV['CS_GO_MIN_BUY'];
                $maxPrice = (float) $_ENV['CS_GO_MAX_BUY'];

                $price = 0;

                /** @var ItemProto $itemProto */
                foreach ($itemList->getItems() as $itemProto) {
                    if ($itemProto->getHashName() === $item->getHashName()) {
                        $price = $itemProto->getWeekPrice() ? $itemProto->getWeekPrice()->getAverage() : 0;
                    }
                }

                if ($price < $minPrice || $price > $maxPrice) {
                    $this->comment("Leaving disabled because of price");
                    continue;
                }

                $this->info('Enabling');
                $this->enableForBuying($item);
            }

            $this->em->clear();
        }

        return 1;
    }
}
