<?php

namespace App\Application\AMQP\CS\Message;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class CSBuy
{
    /** @var int */
    private $decisionId;

    /**
     * CSBuy constructor.
     * @param int $decisionId
     */
    public function __construct(int $decisionId)
    {
        $this->decisionId = $decisionId;
    }

    /**
     * @return int
     */
    public function getDecisionId(): ?int
    {
        return $this->decisionId;
    }
}
