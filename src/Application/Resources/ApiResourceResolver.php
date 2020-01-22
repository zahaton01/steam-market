<?php

namespace App\Application\Resources;

use App\Application\Exception\ApiResource\ApiResourceNotFound;

class ApiResourceResolver
{
    /** @var ApiResourceInterface[]  */
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
     * @return APIResourceInterface|null
     *
     * @throws ApiResourceNotFound
     */
    public function get(string $class): ?APIResourceInterface
    {
        $apiResource = null;
        foreach ($this->resources as $resource) {
            if ($resource->getClass() === $class)
                $apiResource = $resource;
        }

        if (null === $apiResource) {
            throw new ApiResourceNotFound("$class was not found");
        }

        return $apiResource;
    }
}