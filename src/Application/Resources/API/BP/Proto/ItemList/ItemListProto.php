<?php

namespace App\Application\Resources\API\BP\Proto\ItemList;

use App\Application\Resources\API\BP\Proto\ItemList\Model\Item;
use App\Application\Resources\API\BP\Proto\ItemList\Model\ItemPrice;
use App\Application\Resources\Proto\AbstractProto;
use App\Application\Resources\Proto\Exception\MissingProtoFieldException;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class ItemListProto extends AbstractProto
{
    /** @var Item[] */
    private $items;
    /** @var string */
    private $currency;

    /**
     * @return $this
     *
     * @throws MissingProtoFieldException
     */
    public function __invoke()
    {
        if ($this->validate()) {
            $json = $this->getProto()->getDecodedJson();

            $this->currency = $json['currency'];

            foreach ($json['items_list'] as $datum) {
                $item = new Item();
                $item->setHashName($datum['name']);

                if (isset($datum['price'])) {
                    foreach ($datum['price'] as $key => $pricing) {
                        if (!isset($pricing['average']) || !isset($pricing['highest_price']) || !isset($pricing['lowest_price']) || !isset($pricing['sold']))
                            continue;

                        $price = new ItemPrice();
                        $price
                            ->setAverage($pricing['average'])
                            ->setHighestPrice($pricing['highest_price'])
                            ->setLowestPrice($pricing['lowest_price'])
                            ->setMedian($pricing['median'] ?? null)
                            ->setSold((int) $pricing['sold']);

                        switch ($key) {
                            case Item::DAY:
                                $item->setDayPrice($price);
                                break;
                            case Item::WEEK:
                                $item->setWeekPrice($price);
                                break;
                            case Item::MONTH:
                                $item->setMonthPrice($price);
                                break;
                            case Item::ALL:
                                $item->setAllTimePrice($price);
                                break;
                            default:
                                break;
                        }
                    }
                }

                $this->items[] = $item;
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

        if (!isset($json['currency']))
            throw new MissingProtoFieldException('currency is missing');

        if (!isset($json['items_list']))
            throw new MissingProtoFieldException('items_list is missing');

        return true;
    }

    /**
     * @return Item[]
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * @return string
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }
}
