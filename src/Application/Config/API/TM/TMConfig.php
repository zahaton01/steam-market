<?php

namespace App\Application\Config\API\TM;

use App\Application\Config\ConfigInterface;
use App\Application\Exception\Config\ConfigInvokeFailed;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class TMConfig implements ConfigInterface
{
    /** @var array */
    private $config;

    /**
     * @param array $params
     *
     * @return ConfigInterface
     *
     * @throws ConfigInvokeFailed
     */
    public function __invoke(array $params = []): ConfigInterface
    {
        if (!isset($params['project_dir']))
            throw new ConfigInvokeFailed('Missing project dir in params');

        $this->config = json_decode(file_get_contents("{$params['project_dir']}/resources/config/api/tm/tm_config.json"), true);

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