<?php

namespace App\Application\AMQP\CS\Message;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class CSBuyDecision
{
    /** @var string */
    private $hashName;

    /**
     * CSBuyDecision constructor.
     * @param string $hashName
     */
    public function __construct(string $hashName)
    {
        $this->hashName = $hashName;
    }

    /**
     * @return string
     */
    public function getHashName(): ?string
    {
        return $this->hashName;
    }
}
