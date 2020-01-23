<?php

namespace App\Application\Config\API\TM;

use App\Application\Config\ConfigInterface;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class TMConfig implements ConfigInterface
{
    /** @var array */
    private $config;

    /**
     * @param string $projectDir
     *
     * @return ConfigInterface
     */
    public function __invoke(string $projectDir): ConfigInterface
    {
        $this->config = json_decode(file_get_contents("$projectDir/resources/config/api/tm/tm_config.json"), true);

        return $this;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return TMConfig::class;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     *
     * @return self
     */
    public function setConfig(?array $config): self
    {
        $this->config = $config;
        return $this;
    }
}