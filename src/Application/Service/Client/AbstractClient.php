<?php

namespace App\Application\Service\Client;

use GuzzleHttp\Client;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
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
            $symbol = '&';
            if ($counter === 0) {
                $symbol = '?';
            }

            if (is_array($param)) {
                $queryParam = '';
                
                foreach ($param as $val) {
                    $queryParam .= "$key=$val$symbol";
                }
            } else {
                $queryParam = "$key=$param";
            }
            
            $str .= $symbol . $queryParam;
            $counter++;
        }

        return $str;
    }
}
