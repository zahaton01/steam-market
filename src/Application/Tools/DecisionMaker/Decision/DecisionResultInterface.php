<?php

namespace App\Application\Tools\DecisionMaker\Decision;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
interface DecisionResultInterface
{
    /**
     * The hash name of the checked item
     *
     * @param string $hashName
     *
     * @return DecisionResultInterface
     */
    public function setHashName(string $hashName);

    /**
     * The hash name of the checked item
     *
     * @return string
     */
    public function getHashName(): string;
}