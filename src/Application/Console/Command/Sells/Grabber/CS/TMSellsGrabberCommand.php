<?php

namespace App\Application\Console\Command\Sells\Grabber\CS;

use App\Application\Console\Command\Sells\AbstractSellsCommand;
use App\Application\Logs\DB\Console\ConsoleDBLogger;
use App\Application\Resources\API\TM\Proto\Sells\TMPricingProto;
use App\Application\Resources\API\TM\TMMarketplace;
use App\Application\Resources\ApiResourceResolver;
use App\Domain\Entity\CS\CSItem;
use App\Domain\Factory\CS\CSFactoryResolver;
use App\Domain\Factory\CS\Sells\TMPricingFactory;
use App\Domain\Manager\BaseManager;
use App\Domain\Tool\Pagination\Pagination;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class TMSellsGrabberCommand extends AbstractSellsCommand
{
    /** @var ApiResourceResolver  */
    private $resources;
    /** @var CSFactoryResolver  */
    private $factories;

    /**
     * TMSellsGrabberCommand constructor.
     * @param ConsoleDBLogger $logger
     * @param BaseManager $manager
     * @param ApiResourceResolver $apiResourceResolver
     * @param CSFactoryResolver $factoryResolver
     *
     * @throws \Exception
     */
    public function __construct(
        ConsoleDBLogger $logger,
        BaseManager $manager,
        ApiResourceResolver $apiResourceResolver,
        CSFactoryResolver $factoryResolver
    ) {
        parent::__construct($logger, $manager);

        $this->resources = $apiResourceResolver;
        $this->factories = $factoryResolver;
    }

    protected function configure()
    {
        $this
            ->setName('sells:grabber:cs:tm')
            ->setDescription('Grabs sells');
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
        $this->info("Getting relevant items...");
        /** @var TMPricingFactory $pricingFactory */
        $pricingFactory = $this->factories->resolve(TMPricingFactory::class);

        $pagination = new Pagination(1, 1); // faking page size to retrieve total count
        /** @var CSItem[] $relevantItems */
        $relevantItems = $this->manager->getEntityManager()->getRepository(CSItem::class)->getRelevant($pagination);
        $pagination->setTotalItems(count($relevantItems));
        $pagination->setPageSize(50);

        $this->info("Total pages: {$pagination->getTotalPages()}.");
        for ($i = 1; $i <= $pagination->getTotalPages(); $i++) {
            $pagination->setPage($i);

            /** @var CSItem[] $relevantItems */
            $relevantItems = $this->manager->getEntityManager()->getRepository(CSItem::class)->getRelevant($pagination);

            $hashNames = [];
            foreach ($relevantItems as $item) {
                $hashNames[] = $item->getHashName();
            }

            try {
                $this->comment("Getting sells from TM...");
                /** @var TMPricingProto $tmPricingProto */
                $tmPricingProto = $this->resources->resolve(TMMarketplace::class)->getPricing($hashNames);
            } catch (\Exception $e) {
                $this->error($e->getMessage());
                continue;
            }

            $this->info('Done');

            foreach ($tmPricingProto->getPricings() as $tmPricing) {
                foreach ($relevantItems as $item) {
                    if ($item->getHashName() === $tmPricing->getHashName()) {
                        $pricing = $pricingFactory->createFromTM($tmPricing, $item);
                        $this->manager->getEntityManager()->persist($pricing);
                    }
                }
            }

            $this->info("Saving to db...");
            $this->manager->getEntityManager()->flush();
            $this->manager->getEntityManager()->clear();

            if ($i % 2 === 0) { // if we are making more than two requests per second api key will be banned
                sleep(1);
            }
        }

        $this->info("Finished. Execution time {$this->getExecutionTime()} seconds.");
        return 1;
    }
}
