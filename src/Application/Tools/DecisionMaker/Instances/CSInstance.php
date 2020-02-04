<?php

namespace App\Application\Tools\DecisionMaker\Instances;

use App\Application\AMQP\CS\Message\CSBuyDecision;
use App\Application\Tools\DecisionMaker\DecisionMakerInstanceInterface;
use App\Application\Tools\DecisionMaker\Makers\CSDecisionMaker;
use App\Domain\Manager\BaseManager;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class CSInstance implements DecisionMakerInstanceInterface
{
    /** @var CSDecisionMaker */
    private $maker;
    /** @var MessageBusInterface */
    private $messageBus;
    /** @var BaseManager $manager */
    private $manager;

    /**
     * CSInstance constructor.
     * @param CSDecisionMaker $decisionMaker
     * @param MessageBusInterface $messageBus
     * @param BaseManager $manager
     */
    public function __construct(CSDecisionMaker $decisionMaker, MessageBusInterface $messageBus, BaseManager $manager)
    {
        $this->maker = $decisionMaker;
        $this->messageBus = $messageBus;
        $this->manager = $manager;
    }

    /**
     * @param string $hashName
     *
     * @return bool
     */
    public function trigger(string $hashName): bool
    {
        $this->messageBus->dispatch(new CSBuyDecision($hashName));

        return true;
    }

    public function getMaker()
    {
        return $this->maker;
    }
}
