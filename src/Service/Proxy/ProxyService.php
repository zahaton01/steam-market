<?php

namespace App\Service\Proxy;

class ProxyService
{
    /** @var ProxyGrabber  */
    private $grabber;

    public function __construct(ProxyGrabber $grabber)
    {
        $this->grabber = $grabber;
    }

    /**
     * @return ProxyGrabber
     */
    public function getGrabber(): ProxyGrabber
    {
        return $this->grabber;
    }
}
