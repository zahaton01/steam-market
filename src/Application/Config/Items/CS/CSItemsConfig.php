<?php

namespace App\Application\Config\Items\CS;

use App\Application\Config\ConfigInterface;
use App\Application\Exception\Config\ConfigInvokeFailed;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class CSItemsConfig implements ConfigInterface
{
    /** @var ContainerInterface */
    private $container;
    /** @var array */
    private $bannedForBuying;

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
            $this->bannedForBuying = json_decode(file_get_contents("{$this->container->getParameter('kernel.project_dir')}/resources/config/items/cs/relevant.json"), true);
        } catch (\Exception $e) {
            throw new ConfigInvokeFailed($e->getMessage(), $e->getCode(), $e);
        }

        if (!$this->bannedForBuying) {
            throw new ConfigInvokeFailed('Failed to retrieve data of cs items config');
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBannedForBuying()
    {
        return $this->bannedForBuying;
    }
}
