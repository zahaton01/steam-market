<?php

namespace App\Proto;

abstract class AbstractProto
{
    /**
     * @var JSONProto
     */
    private $proto;

    /**
     * AbstractProto constructor.
     * @param JSONProto|null $proto
     */
    public function __construct(JSONProto $proto = null)
    {
        $this->proto = $proto;
    }

    /**
     * @return JSONProto
     */
    public function getProto(): ?JSONProto
    {
        return $this->proto;
    }

    /**
     * @param JSONProto $proto
     *
     * @return self
     */
    public function setProto(?JSONProto $proto): self
    {
        $this->proto = $proto;
        return $this;
    }

    /**
     * @return bool
     */
    protected function hasProto(): bool
    {
        return null !== $this->proto;
    }

    /**
     * Returns model which represents data from JsonProto
     *
     * @param null $params
     *
     * @return mixed
     */
    abstract function init($params = null);
}