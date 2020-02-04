<?php

namespace App\Application\Tools\DecisionMaker\Makers;

use App\Application\Resources\ApiResourceResolver;
use App\Domain\Manager\BaseManager;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
abstract class AbstractMaker
{
    /** @var BaseManager */
    protected $manager;
    /** @var ApiResourceResolver */
    protected $resources;

    /**
     * AbstractMaker constructor.
     * @param BaseManager $manager
     * @param ApiResourceResolver $resourceResolver
     */
    public function __construct(BaseManager $manager, ApiResourceResolver $resourceResolver)
    {
        $this->manager = $manager;
        $this->resources = $resourceResolver;
    }
}
