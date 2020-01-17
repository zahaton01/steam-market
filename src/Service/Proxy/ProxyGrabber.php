<?php

namespace App\Service\Proxy;

use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProxyGrabber
{
    private const API_URL = 'http://127.0.0.1:55555/api/v1';

    /** @var Client */
    private $client;
    /** @var ContainerInterface */
    private $container;

    /**
     * ProxyGrabber constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->client = new Client([
            'stream' => false
        ]);
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function fromInternalApi()
    {
        $response = $this->client->request('POST', self::API_URL . '/', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'model' => 'proxy',
                'method' => 'get'
            ], JSON_UNESCAPED_UNICODE)
        ]);

        $response = json_decode($response->getBody(), true);

        $proxies = [];
        foreach ($response['data'] as $item) {
            if (!$item['bad_proxy'] && $item['response_time'] < 60000) {
                $proxies[] = $item['address'];
            }
        }

        return $proxies;
    }

    /**
     * @return array
     */
    public function fromParameters(): array
    {
        return $this->container->getParameter('proxies');
    }
}
