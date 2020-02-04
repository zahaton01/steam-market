<?php

namespace App\Application\Resources\API\TM\Proto\Buy\CS;

use App\Application\Resources\Proto\AbstractProto;
use App\Application\Resources\Proto\Exception\MissingProtoFieldException;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class BoughtProto extends AbstractProto
{
    /** @var string */
    private $customId;
    /** @var string */
    private $itemId;

    /**
     * @return $this|mixed
     *
     * @throws MissingProtoFieldException
     */
    public function __invoke()
    {
        if ($this->validate()) {
            $json = $this->getProto()->getDecodedJson();

            $this->customId = $json['custom_id'];
            $this->itemId = $json['id'] ?? null;
        }

        return $this;
    }

    /**
     * @return bool
     *
     * @throws MissingProtoFieldException
     */
    public function validate(): bool
    {
        $json = $this->getProto()->getDecodedJson();

        if (!isset($json['custom_id']))
            throw new MissingProtoFieldException('Custom id is missing');

        return true;
    }

    /**
     * @return string
     */
    public function getCustomId(): ?string
    {
        return $this->customId;
    }

    /**
     * @param string $customId
     *
     * @return self
     */
    public function setCustomId(?string $customId): self
    {
        $this->customId = $customId;
        return $this;
    }

    /**
     * @return string
     */
    public function getItemId(): ?string
    {
        return $this->itemId;
    }

    /**
     * @param string $itemId
     *
     * @return self
     */
    public function setItemId(?string $itemId): self
    {
        $this->itemId = $itemId;
        return $this;
    }
}
