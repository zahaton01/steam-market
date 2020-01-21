<?php

namespace App\Command\Grabber\CS;

use App\Command\AbstractCommand;
use App\Entity\CS\CSItem;
use App\Factory\CommandOutputFactory;
use App\Factory\CS\CSItemFactory;
use App\Factory\CS\Resolver\CSFactoryResolver;
use App\Logs\CommandLogService;
use App\Manager\BaseManager;
use App\Model\Currency;
use App\Proto\BP\ItemList\ItemListProto;
use App\Proto\BP\ItemList\ItemProto;
use App\Service\Marketplace\Steam\SteamMarketplace;
use App\Service\ResourceAPIs\BP\BPResource;
use App\Service\ResourceAPIs\Resolver\ResourceAPIsResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CSBPGrabberCommand extends AbstractCommand
{
    /** @var SteamMarketplace */
    private $steamMarketplace;
    /** @var CSFactoryResolver */
    private $csFactories;
    /** @var ResourceAPIsResolver */
    private $resources;
    /** @var EntityManagerInterface */
    private $em;

    /**
     * CSBPGrabberCommand constructor.
     * @param CommandLogService $logger
     * @param CommandOutputFactory $commandOutputFactory
     * @param BaseManager $manager
     * @param SteamMarketplace $steamMarketplace
     * @param CSFactoryResolver $csFactories
     * @param ResourceAPIsResolver $resourceAPIsResolver
     * @param EntityManagerInterface $em
     */
    public function __construct(
        CommandLogService $logger,
        CommandOutputFactory $commandOutputFactory,
        BaseManager $manager,
        SteamMarketplace $steamMarketplace,
        CSFactoryResolver $csFactories,
        ResourceAPIsResolver $resourceAPIsResolver,
        EntityManagerInterface $em
    )
    {
        parent::__construct($logger, $commandOutputFactory, $manager);

        $this->steamMarketplace = $steamMarketplace;
        $this->csFactories = $csFactories;
        $this->resources = $resourceAPIsResolver;
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setName('grabber:cs:bp')
            ->setDescription('Grabs CS GO items');
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

        $this->info('Getting items from CSGOBackpack');
        /** @var ItemListProto $items */
        $items = $this->resources->get(BPResource::class)->retrieveItems(Currency::RUB);
        $this->comment('Done');

        foreach ($items->getItems() as $item) {
            if ($this->isItemExist($item))
                continue;

            $this->spacedInfo("Saving {$item->getHashName()}");
            $itemEntity = $this->csFactories->get(CSItemFactory::class)->create($item->getHashName());

            try {
                $this->manager->save($itemEntity);
                $this->comment('Done');
            } catch (\Exception $e) {
                $this->spacedError($e->getMessage());

                continue;
            }
        }

        $this->spacedComment('Finished');
        return 1;
    }

    /**
     * @param ItemProto $proto
     *
     * @return bool
     */
    private function isItemExist(ItemProto $proto): bool
    {
        $item = $this->em->getRepository(CSItem::class)->findOneBy(['hashName' => $proto->getHashName()]);

        if (null === $item) {
            return false;
        }

        return true;
    }
}
