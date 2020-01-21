<?php

namespace App\Service\ResourceAPIs\Resolver;

use App\Service\ResourceAPIs\APIResourceInterface;

class ResourceAPIsResolver
{
    /** @var APIResourceInterface[]  */
    private $resources;

    /**
     * CSFactoryResolver constructor.
     * @param iterable $resources
     */
    public function __construct(iterable $resources)
    {
        $this->resources = $resources;
    }

    /**
     * @param string $class
     *
     * @return mixed|null
     */
    public function get(string $class): ?APIResourceInterface
    {
        foreach ($this->resources as $resource) {
            if ($resource->getClass() === $class)
                return $resource;
        }

        return null;
    }
}
