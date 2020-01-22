<?php

namespace App\Application\Service\Client;

use GuzzleHttp\Client;

abstract class AbstractClient
{
    /** @var Client  */
    protected $client;

    /**
     * AbstractClient constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'cookies' => true
        ]);
    }

    /**
     * @param string $proxy
     *
     * @return $this
     */
    protected function withProxy(string $proxy): self
    {
        $this->client = new Client([
            'cookies' => true,
            'proxy' => $proxy
        ]);

        return $this;
    }

    /**
     * @param array $params
     *
     * @return string
     */
    protected function formQuery(array $params)
    {
        $str = '';
        $counter = 0;

        foreach ($params as $key => $param) {
            if ($counter === 0) {
                $str .= "?$key=$param";
            } else {
                $str .= "&$key=$param";
            }

            $counter++;
        }

        return $str;
    }
}
