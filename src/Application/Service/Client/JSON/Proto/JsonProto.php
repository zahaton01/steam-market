<?php

namespace App\Application\Service\Client\JSON\Proto;

class JsonProto
{
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
    public function __construct(string $initialJson)
    {
        $this->decodedJson = json_decode($initialJson, true);
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
