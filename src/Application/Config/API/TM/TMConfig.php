<?php

namespace App\Application\Config\API\TM;

use App\Application\Config\ConfigInterface;
use App\Application\Exception\Config\ConfigInvokeFailed;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class TMConfig implements ConfigInterface
{
    /** @var array */
    private $config;
    /** @var ContainerInterface */
    private $container;

    /**
     * CSItemsConfig constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return ConfigInterface
     *
     * @throws ConfigInvokeFailed
     */
    public function __invoke(): ConfigInterface
    {
        try {
            $this->config = json_decode(file_get_contents("{$this->container->getParameter('kernel.project_dir')}/resources/config/api/tm/tm_config.json"), true);
        } catch (\Exception $e) {
            throw new ConfigInvokeFailed($e->getMessage(), $e->getCode(), $e);
        }

        if (!$this->config) {
            throw new ConfigInvokeFailed('Failed to retrieve data of TM API');
        }

        return $this;
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
