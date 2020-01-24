<?php

namespace App\Application\Config\Exchanger;

use App\Application\Config\ConfigInterface;
use App\Application\Exception\Config\ConfigInvokeFailed;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class ExchangerConfig implements ConfigInterface
{
    /** @var array */
    private $rates;
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
            $this->rates = json_decode(file_get_contents("{$this->container->getParameter('kernel.project_dir')}/resources/config/tools/exchanger/exchange_rates.json"), true);
        } catch (\Exception $e) {
            throw new ConfigInvokeFailed($e->getMessage(), $e->getCode(), $e);
        }

        if (!$this->rates) {
            throw new ConfigInvokeFailed('Failed to retrieve data of exchange rates');
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getRates(): array
    {
        return $this->rates;
    }

    /**
     * @param array $rates
     *
     * @return self
     */
    public function setRates(?array $rates): self
    {
        $this->rates = $rates;
        return $this;
    }
}