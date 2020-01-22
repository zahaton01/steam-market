<?php

namespace App\Application\Resources\API\TM\Proto\ItemInstances\CS;

use App\Application\Resources\API\TM\Proto\ItemInstances\CS\Model\ItemInstance;
use App\Application\Resources\Proto\AbstractProto;
use App\Application\Resources\Proto\Exception\MissingProtoFieldException;

class ItemInstancesProto extends AbstractProto
{
    /** @var string */
    private $hashName;
    /** @var ItemInstance[] */
    private $instances;

    /**
     * @return $this
     *
     * @throws MissingProtoFieldException
     */
    public function __invoke()
    {
        if ($this->validate()) {
            $data = $this->getProto()->getDecodedJson()['data'];

            foreach ($data as $datum) {
                $instance = new ItemInstance();
                $instance
                    ->setPrice($datum['price'] / 100)
                    ->setCurrency($this->getProto()->getDecodedJson()['currency'] ?? null)
                    ->setHashName($datum['market_hash_name'])
                    ->setQuantity($datum['count'])
                    ->setInstance($datum['class'] . '_' . $datum['instance']);

                $this->instances[] = $instance;
            }
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

        if (!isset($json['data']))
            throw new MissingProtoFieldException('Data is missing in Json Proto');

        return true;
    }

    /**
     * @return string
     */
    public function getHashName(): ?string
    {
        return $this->hashName;
    }

    /**
     * @return ItemInstance[]
     */
    public function getInstances(): ?array
    {
        return $this->instances;
    }
}
