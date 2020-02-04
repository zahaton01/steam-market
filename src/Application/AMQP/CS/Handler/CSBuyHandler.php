<?php

namespace App\Application\AMQP\CS\Handler;

use App\Application\AMQP\CS\Message\CSBuy;
use App\Application\Logs\DB\Console\ConsoleDBLogger;
use App\Application\Resources\API\TM\TMMarketplace;
use App\Application\Resources\ApiResourceResolver;
use App\Domain\Entity\Decision\CSBuyingDecision;
use App\Domain\Entity\Queue\CSTMItemDecisionQueue;
use App\Domain\Factory\BuyHistory\CSBuyHistoryFactory;
use App\Domain\Manager\BaseManager;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class CSBuyHandler implements MessageHandlerInterface
{
    /** @var ConsoleDBLogger */
    private $logger;
    /** @var ApiResourceResolver */
    private $resources;
    /** @var CSBuyHistoryFactory */
    private $buyHistoryFactory;
    /** @var BaseManager */
    private $manager;

    /**
     * CSBuyHandler constructor.
     * @param ConsoleDBLogger $logger
     * @param ApiResourceResolver $resourceResolver
     * @param CSBuyHistoryFactory $buyHistoryFactory
     * @param BaseManager $manager
     */
    public function __construct(
        ConsoleDBLogger $logger,
        ApiResourceResolver $resourceResolver,
        CSBuyHistoryFactory $buyHistoryFactory,
        BaseManager $manager
    ) {
        $this->logger = $logger;
        $this->resources = $resourceResolver;
        $this->buyHistoryFactory = $buyHistoryFactory;
        $this->manager = $manager;
    }

    /**
     * @param CSBuy $message
     */
    public function __invoke(CSBuy $message)
    {
        try {
            /** @var CSBuyingDecision $decisionEntity */
            $decisionEntity = $this->manager->getEntityManager()->getRepository(CSBuyingDecision::class)->find($message->getDecisionId());
            /** @var TMMarketplace $tmMarketplace */
            $tmMarketplace = $this->resources->resolve(TMMarketplace::class);
            $proto = $tmMarketplace->buyCs($decisionEntity->getHashName(), $decisionEntity->getBuyPrice());

            $buyHistory = $this->buyHistoryFactory->create($proto, $decisionEntity);
            $this->manager->save($buyHistory);

            $queued = $this->manager->getEntityManager()->getRepository(CSTMItemDecisionQueue::class)->findOneBy(['hashName' => $decisionEntity->getHashName()]); // Removing from db queue
            if (null !== $queued) {
                $this->manager->remove($queued);
            }

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
