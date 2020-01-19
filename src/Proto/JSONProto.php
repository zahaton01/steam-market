<?php

namespace App\Proto;

class JSONProto
{
    /**
     * Encoded json response from requested resource
     *
     * @var string
     */
    protected $initialJson;

    /**
     * Decoded json response
     *
     * @var array
     */
    protected $decodedJson;

    /**
     * AbstractJSONProto constructor.
     * @param string|null $initialJson
     */
    public function __construct(string $initialJson = null)
    {
        $this->initialJson = $initialJson;
        $this->decodedJson = json_decode($initialJson, true);
    }

    /**
     * @return string
     */
    public function getInitialJson(): ?string
    {
        return $this->initialJson;
    }

    /**
     * @param string $initialJson
     *
     * @return self
     */
    public function setInitialJson(?string $initialJson): self
    {
        $this->initialJson = $initialJson;
        return $this;
    }

    /**
     * @return array
     */
    public function getDecodedJson(): ?array
    {
        return $this->decodedJson;
    }

    /**
     * @param array $decodedJson
     *
     * @return self
     */
    public function setDecodedJson(?array $decodedJson): self
    {
        $this->decodedJson = $decodedJson;
        return $this;
    }
}