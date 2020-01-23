<?php

namespace App\Application\Config;

use App\Application\Exception\Config\ConfigInvokeFailed;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class ConfigResolver
{
    /** @var ConfigInterface[] */
    private $configs;
    /** @var string */
    private $projectDir;

    /**
     * ConfigResolver constructor.
     * @param iterable $configs
     * @param string $projectDir
     */
    public function __construct(iterable $configs, string $projectDir)
    {
        $this->configs = $configs;
        $this->projectDir = $projectDir;
    }

    /**
     * @param string $class
     *
     * @return ConfigInterface
     *
     * @throws ConfigInvokeFailed
     */
    public function resolve(string $class): ConfigInterface
    {
        foreach ($this->configs as $config) {
            if ($config->getClass() === $class) {
                return $config->__invoke([
                    'project_dir' => $this->projectDir
                ]);
            }
        }

        return null;
    }
}
