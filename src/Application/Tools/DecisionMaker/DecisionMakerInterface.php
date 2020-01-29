<?php

namespace App\Application\Tools\DecisionMaker;

use App\Application\Tools\DecisionMaker\Decision\DecisionResultInterface;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
interface DecisionMakerInterface
{
    /**
     * @return DecisionResultInterface
     */
    public function shallWeBuy(): DecisionResultInterface;
}