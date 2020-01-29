<?php

namespace App\Application\Tools\DecisionMaker;

use App\Application\Tools\DecisionMaker\Exception\InstanceNotExist;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class DecisionMaker
{
    /** @var DecisionMakerInstanceInterface[] */
    private $instances;

    /**
     * DecisionMaker constructor.
     * @param iterable $instances
     */
    public function __construct(iterable $instances)
    {
        $this->instances = $instances;
    }

    /**
     * @param string $class
     *
     * @return DecisionMakerInstanceInterface|null
     *
     * @throws InstanceNotExist
     */
    public function getInstance(string $class): DecisionMakerInstanceInterface
    {
        $resolved = null;
        foreach ($this->instances as $instance) {
            if (get_class($instance) === $class) {
                $resolved = $instance;
            }
        }

        if (null === $resolved) {
            throw new InstanceNotExist("$class was not found");
        }

        return $resolved;
    }
}