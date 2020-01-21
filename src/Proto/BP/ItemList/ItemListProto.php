<?php

namespace App\Proto\BP\ItemList;

use App\Proto\AbstractProto;
use App\Proto\JSONProto;

class ItemListProto extends AbstractProto
{
    /** @var ItemProto[] */
    private $items;
    /** @var string */
    private $currency;

    /**
     * ItemListProto constructor.
     *
     * @param JSONProto|null $proto
     */
    public function __construct(JSONProto $proto = null)
    {
        parent::__construct($proto);

        if ($this->hasProto()) {
            $this->init();
        }
    }

    /**
     * @param null $data
     * @param array $params
     *
     * @return $this|mixed
     */
    public function init($data = null, array $params = [])
    {
        if ($this->hasProto()) {
            $data = $this->getProto()->getDecodedJson();
            $this->currency = $data['currency'];

            foreach ($data['items_list'] as $item) {
                $this->addItem((new ItemProto())->init($item));
            }
        }

        return $this;
    }

    /**
     * @return ItemProto[]
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * @param ItemProto $item
     *
     * @return self
     */
    public function addItem(ItemProto $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return self
     */
    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }
}
