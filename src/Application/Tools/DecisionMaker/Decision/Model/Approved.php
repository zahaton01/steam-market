<?php

namespace App\Application\Tools\DecisionMaker\Decision\Model;

use App\Application\Tools\DecisionMaker\Decision\DecisionResultInterface;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class Approved implements DecisionResultInterface
{
    /** @var string */
    private $hashName;

    /**
     * @return string
     */
    public function getHashName(): string
    {
        return $this->hashName;
    }

    /**
     * @param string $hashName
     *
     * @return self
     */
    public function setHashName(string $hashName)
    {
        $this->hashName = $hashName;
        return $this;
    }
}