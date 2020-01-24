<?php

namespace App\Application\Config;

use App\Application\Exception\Config\ConfigInvokeFailed;
use App\Application\Exception\Config\ConfigNotFound;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class ConfigResolver
{
    /** @var ConfigInterface[] */
    private $configs;

    /**
     * ConfigResolver constructor.
     * @param iterable $configs
     */
    public function __construct(iterable $configs)
    {
        $this->configs = $configs;
    }

    /**
     * @param string $class
     *
     * @return ConfigInterface
     *
     * @throws ConfigInvokeFailed
     * @throws ConfigNotFound
     */
    public function resolve(string $class): ConfigInterface
    {
        $resolved = null;
        foreach ($this->configs as $config) {
            if (get_class($config) === $class) {
                $resolved = $config->__invoke();
            }
        }

        if (null === $resolved) {
            throw new ConfigNotFound("$class was not found");
        }

        return $resolved;
    }
}
