<?php

namespace App\Domain\Factory\CS;

use App\Domain\Exception\Factory\FactoryNotFound;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class CSFactoryResolver
{
    /** @var CSFactoryInterface[]  */
    private $factories;

    /**
     * CSFactoryResolver constructor.
     * @param iterable $factories
     */
    public function __construct(iterable $factories)
    {
        $this->factories = $factories;
    }

    /**
     * @param string $class
     *
     * @return CSFactoryInterface
     *
     * @throws FactoryNotFound
     */
    public function resolve(string $class): ?CSFactoryInterface
    {
        $resolved = null;
        foreach ($this->factories as $factory) {
            if (get_class($factory) === $class)
                $resolved = $factory;
        }

        if (null === $resolved) {
            throw new FactoryNotFound("$class was not found");
        }

        return $resolved;
    }
}
