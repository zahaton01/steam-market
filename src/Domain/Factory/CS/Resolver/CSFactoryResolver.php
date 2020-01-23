<?php

namespace App\Domain\Factory\CS\Resolver;

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
     * @return mixed|null
     */
    public function get(string $class): ?CSFactoryInterface
    {
        foreach ($this->factories as $factory) {
            if ($factory->getClass() === $class)
                return $factory;
        }

        return null;
    }
}
