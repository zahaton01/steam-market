<?php

namespace App\Application\Resources\API\TM\Proto\Prices;

use App\Application\Resources\API\TM\Proto\Prices\Model\ItemPrice;
use App\Application\Resources\Proto\AbstractProto;
use App\Application\Resources\Proto\Exception\MissingProtoFieldException;

class PricesProto extends AbstractProto
{
    /** @var ItemPrice[] */
    private $prices;

    /**
     * @return $this
     *
     * @throws MissingProtoFieldException
     */
    public function __invoke()
    {
        if ($this->validate()) {
            foreach ($this->getProto()->getDecodedJson()['items'] as $data) {
                $this->prices[] =
                    (new ItemPrice())
                    ->setHashName($data['market_hash_name'])
                    ->setPrice($data['price']);
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

        if (!isset($json['items']))
            throw new MissingProtoFieldException('Items are missing in Json Proto');

        return true;
    }

    /**
     * @return ItemPrice[]
     */
    public function getPrices(): ?array
    {
        return $this->prices;
    }
}
