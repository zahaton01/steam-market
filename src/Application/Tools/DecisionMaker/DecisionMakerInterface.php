<?php

namespace App\Application\Tools\DecisionMaker;

use App\Application\Tools\DecisionMaker\Decision\DecisionResultInterface;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
interface DecisionMakerInterface
{
    /**
     * @param string $hashName
     *
     * @return DecisionResultInterface
     */
    public function shallWeBuyFromTM(string $hashName);
}
