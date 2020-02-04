<?php

namespace App\Application\AMQP\CS\Handler;

use App\Application\AMQP\CS\Message\CSBuy;
use App\Application\AMQP\CS\Message\CSBuyDecision;
use App\Application\Logs\DB\Console\ConsoleDBLogger;
use App\Application\Tools\DecisionMaker\DecisionMaker;
use App\Application\Tools\DecisionMaker\Instances\CSInstance;
use App\Application\Tools\DecisionMaker\Makers\CSDecisionMaker;
use App\Domain\Entity\Queue\CSTMItemDecisionQueue;
use App\Domain\Factory\Decision\CSBuyingDecisionFactory;
use App\Domain\Manager\BaseManager;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class CSBuyDecisionHandler implements MessageHandlerInterface
{
    /** @var DecisionMaker  */
    private $decisionMaker;
    /** @var MessageBusInterface  */
    private $messageBus;
    /** @var BaseManager */
    private $manager;
    /** @var CSBuyingDecisionFactory */
    private $decisionFactory;
    /** @var ConsoleDBLogger */
    private $logger;

    /**
     * CSBuyDecisionHandler constructor.
     * @param DecisionMaker $decisionMaker
     * @param MessageBusInterface $messageBus
     * @param BaseManager $manager
     * @param CSBuyingDecisionFactory $buyingDecisionFactory
     * @param ConsoleDBLogger $logger
     */
    public function __construct(
        DecisionMaker $decisionMaker,
        MessageBusInterface $messageBus,
        BaseManager $manager,
        CSBuyingDecisionFactory $buyingDecisionFactory,
        ConsoleDBLogger $logger
    ) {
        $this->decisionMaker = $decisionMaker;
        $this->messageBus = $messageBus;
        $this->manager = $manager;
        $this->decisionFactory = $buyingDecisionFactory;
        $this->logger = $logger;
    }

    /**
     * @param CSBuyDecision $decision
     */
    public function __invoke(CSBuyDecision $decision)
    {
        try {
            /** @var CSDecisionMaker $maker */
            $maker = $this->decisionMaker->getInstance(CSInstance::class)->getMaker();
            $decision = $maker->shallWeBuyFromTM($decision->getHashName());

            $decisionEntity = $this->decisionFactory->createFromDecision($decision);
            $decisionEntity = $this->manager->save($decisionEntity);

            if ($decision->isApproved()) {
                $this->messageBus->dispatch(new CSBuy($decisionEntity->getId()));
            } else {
                $queued = $this->manager->getEntityManager()->getRepository(CSTMItemDecisionQueue::class)->findOneBy(['hashName' => $decision->getResult()->getHashName()]); // Removing from db queue
                if (null !== $queued) {
                    $this->manager->remove($queued); // removing from queue for next iteration
                }
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
