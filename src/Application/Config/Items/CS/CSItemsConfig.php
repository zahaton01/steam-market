<?php

namespace App\Application\Config\Items\CS;

use App\Application\Config\ConfigInterface;
use App\Application\Exception\Config\ConfigInvokeFailed;

class CSItemsConfig implements ConfigInterface
{
    /** @var array */
    private $bannedForBuying;

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

        $this->bannedForBuying = json_decode(file_get_contents("{$params['project_dir']}/resources/config/items/cs/relevant.json"), true);

        return $this;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return CSItemsConfig::class;
    }

    /**
     * @return mixed
     */
    public function getBannedForBuying()
    {
        return $this->bannedForBuying;
    }
}
