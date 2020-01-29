<?php

namespace App\Application\Tools\DecisionMaker\Instances;

use App\Application\Tools\DecisionMaker\DecisionMakerInstanceInterface;
use App\Application\Tools\DecisionMaker\Makers\CSDecisionMaker;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class CSInstance implements DecisionMakerInstanceInterface
{
    /** @var CSDecisionMaker */
    private $maker;

    /**
     * CSInstance constructor.
     * @param CSDecisionMaker $decisionMaker
     */
    public function __construct(CSDecisionMaker $decisionMaker)
    {
        $this->maker = $decisionMaker;
    }

    public function trigger(string $hashName): bool
    {

    }

    public function getMaker()
    {

    }
}