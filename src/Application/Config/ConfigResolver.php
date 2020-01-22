<?php

namespace App\Application\Config;

class ConfigResolver
{
    /** @var array */
    private $exchanger = [];
    /** @var array */
    private $tm;

    /**
     * ConfigResolver constructor.
     * @param string $projectDir
     */
    public function __construct(string $projectDir)
    {
        $this->exchanger['rates'] = json_decode(file_get_contents("$projectDir/resources/tools/exchanger/exchange_rates.json"), true);
        $this->tm = json_decode(file_get_contents("$projectDir/resources/api/tm/tm_config.json"), true);
    }

    /**
     * @return array
     */
    public function getExchanger(): ?array
    {
        return $this->exchanger;
    }

    /**
     * @return array
     */
    public function getTm(): ?array
    {
        return $this->tm;
    }
}
