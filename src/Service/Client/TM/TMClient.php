<?php

namespace App\Service\Client\TM;

use App\Service\Client\AbstractClient;

class TMClient extends AbstractClient
{
    private const URL_PRICES = 'https://market.csgo.com/api/v2/prices/';
    private const URL_ALL_INSTANCES = 'https://market.csgo.com/api/v2/prices/class_instance/';
    private const URL_ITEM_INSTANCES = 'https://market.csgo.com/api/v2/search-item-by-hash-name';
    private const URL_ITEM_SELLS_HISTORY = 'https://market.csgo.com/api/v2/get-list-items-info';

    /** @var string */
    private $csApiKey;

    /**
     * TMClient constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->csApiKey = $_ENV['CS_TM_API_KEY'];
    }

    public function getPrices(string $currency)
    {

    }
}