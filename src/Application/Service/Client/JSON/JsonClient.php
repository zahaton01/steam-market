<?php

namespace App\Application\Service\Client\JSON;

use App\Application\Exception\Client\BadResponseException;
use App\Application\Service\Client\AbstractClient;
use App\Application\Service\Client\JSON\Proto\JsonProto;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class JsonClient extends AbstractClient
{
    private const CONTENT_TYPE_JSON = 'application/json';

    /**
     * @param string $url
     * @param array $params
     * @param array $options
     *
     * @return JsonProto
     *
     * @throws BadResponseException
     */
    protected function getJson(string $url, array $params = [], array $options = []): JsonProto
    {
        if (count($params) > 0) {
            $url .= $this->formQuery($params);
        }

        try {
            $response = $this->client->request("GET", $url);
        } catch (ServerException | ClientException $e) {
            throw new BadResponseException($e->getMessage(), $e->getCode(), $e);
        }

        $contents = $response->getBody()->getContents();

        if (null === $contents) {
            throw new BadResponseException('Response is empty');
        }

        return new JsonProto($contents);
    }
}
