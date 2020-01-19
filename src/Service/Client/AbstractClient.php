<?php

namespace App\Service\Client;

use App\Exception\BadResponseException;
use App\Proto\JSONProto;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

abstract class AbstractClient
{
    public const CONTENT_TYPE_JSON = 'application/json';

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
     * @param string $url
     * @param array $params
     * @param array $options
     *
     * @return JSONProto
     *
     * @throws BadResponseException
     */
    protected function getJson(string $url, array $params = [], array $options = []): JSONProto
    {
        if (count($params) > 0) {
            $url .= $this->formQuery($params);
        }

        try {
            $response = $this->client->request("GET", $url);
        } catch (ServerException | ClientException $e) {
            throw new BadResponseException($e->getMessage());
        }

        $contents = $response->getBody()->getContents();

        if (null === $contents) {
            throw new BadResponseException('Response is empty');
        }

        return new JSONProto($contents);
    }

    protected function postJson()
    {
        // TODO
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
    private function formQuery(array $params)
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