<?php

namespace App\Application\Tools\DecisionMaker;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
interface DecisionMakerInstanceInterface
{
    /**
     * Triggers the decision maker. It is used to add the item to queue of AMQP protocol.
     *
     * Another process consumes items and makes decision.
     *
     * @param string $hashName
     *
     * @return bool
     */
    public function trigger(string $hashName): bool;

    /**
     * Return the decision maker for consumer to make the decision
     *
     * @return DecisionMakerInterface
     */
    public function getMaker();
}