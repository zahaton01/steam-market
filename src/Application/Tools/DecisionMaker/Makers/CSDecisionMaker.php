<?php

namespace App\Application\Tools\DecisionMaker\Makers;

use App\Application\Config\ConfigResolver;
use App\Application\Config\Items\CS\CSItemsConfig;
use App\Application\Exception\Config\ConfigInvokeFailed;
use App\Application\Exception\Config\ConfigNotFound;
use App\Application\Tools\DecisionMaker\DecisionMakerInterface;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class CSDecisionMaker implements DecisionMakerInterface
{
    /** @var CSItemsConfig  */
    private $config;

    /**
     * CSDecisionMaker constructor.
     * @param ConfigResolver $configResolver
     *
     * @throws ConfigInvokeFailed
     * @throws ConfigNotFound
     */
    public function __construct(ConfigResolver $configResolver)
    {
        $this->config = $configResolver->resolve(CSItemsConfig::class);
    }

    public function shallWeBuy()
    {
        // TODO: Implement shallWeBuy() method.
    }
}