<?php

namespace App\Application\Console\Command\Grabber\CS;

use App\Application\Console\Command\Grabber\AbstractGrabberCommand;
use App\Application\Logs\DB\Console\ConsoleDBLogger;
use App\Application\Model\Currency;
use App\Application\Resources\API\BP\BPResource;
use App\Application\Resources\API\BP\Proto\ItemList\ItemListProto;
use App\Application\Resources\ApiResourceResolver;
use App\Domain\Entity\CS\CSItem;
use App\Domain\Factory\CS\CSFactoryResolver;
use App\Domain\Factory\CS\Item\CSItemFactory;
use App\Domain\Manager\BaseManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class BPGrabberCommand extends AbstractGrabberCommand
{
    /** @var CSFactoryResolver */
    private $factories;
    /** @var ApiResourceResolver */
    private $resources;

    /**
     * BPGrabberCommand constructor.
     * @param ConsoleDBLogger $logger
     * @param BaseManager $manager
     * @param ApiResourceResolver $resources
     * @param CSFactoryResolver $factories
     *
     * @throws \Exception
     */
    public function __construct(
        ConsoleDBLogger $logger,
        BaseManager $manager,
        ApiResourceResolver $resources,
        CSFactoryResolver $factories
    ) {
        parent::__construct($logger, $manager);

        $this->factories = $factories;
        $this->resources = $resources;
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
        $items = $this->resources->resolve(BPResource::class)->getItemList(Currency::RUB);
        $this->comment('Done. Saving...');

        foreach ($items->getItems() as $item) {
            if ($this->doesItemExist($item->getHashName(), CSItem::class))
                continue;

            $this->info("Saving {$item->getHashName()}");
            $itemEntity = $this->factories->resolve(CSItemFactory::class)->create($item->getHashName());
            $this->manager->getEntityManager()->persist($itemEntity);
        }

        try {
            $this->manager->getEntityManager()->flush();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->comment("Finished. Execution time: {$this->getExecutionTime()} seconds");
        return 1;
    }
}
