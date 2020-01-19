<?php

namespace App\Proto\TM\Prices\CS;

use App\Proto\AbstractProto;
use App\Proto\JSONProto;

class CSTMPricesProto extends AbstractProto
{
    /** @var CSTMPriceProto[] */
    private $prices;

    /**
     * CSTMPricesProto constructor.
     *
     * @param JSONProto|null $proto
     */
    public function __construct(JSONProto $proto = null)
    {
        parent::__construct($proto);

        if (null !== $proto) {
            $this->init();
        }
    }

    /**
     * @param null $data
     *
     * @return $this
     */
    public function init($data = null)
    {
        if ($this->hasProto()) {
            foreach ($this->getProto()->getDecodedJson()['prices'] as $price) {
                $priceProto = (new CSTMPriceProto())->init($price);
                $this->addPrice($priceProto);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getPrices(): ?array
    {
        return $this->prices;
    }

    /**
     * @param CSTMPriceProto $priceProto
     *
     * @return self
     */
    public function addPrice(CSTMPriceProto $priceProto): self
    {
        $this->prices[] = $priceProto;
        return $this;
    }
}