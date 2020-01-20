<?php

namespace App\Proto\TM\Sells\CS;

use App\Proto\AbstractProto;
use App\Proto\JSONProto;

class CSTMSellsProto extends AbstractProto
{
    /** @var float */
    private $minPrice;
    /** @var float */
    private $maxPrice;
    /** @var float */
    private $averagePrice;
    /** @var string */
    private $currency;
    /** @var CSTMSellProto[] */
    private $sells;

    /**
     * CSTMSellsProto constructor.
     * @param JSONProto|null $proto
     *
     * @throws \Exception
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
     *
     * @throws \Exception
     */
    public function init($data = null, array $params = [])
    {
        if ($this->hasProto()) {
            /**
             * It returns array with one element. And the key of this element is hashName.
             * So we must do a little trick to retrieve data
             */
            $data = $this->getProto()->getDecodedJson()['data'];
            $this->currency = $this->getProto()->getDecodedJson()['currency'];

            foreach ($data as $key => $datum) {
                $this->minPrice = $datum['min'];
                $this->maxPrice = $datum['max'];
                $this->averagePrice = $datum['average'];

                foreach ($datum['history'] as $sell) {
                    $instanceSell = new CSTMSellProto();
                    $this->addSell($instanceSell->init($sell));
                }

                break; // this trick
            }
        }

        return $this;
    }

    /**
     * @return float
     */
    public function getMinPrice(): ?float
    {
        return $this->minPrice;
    }

    /**
     * @param float $minPrice
     *
     * @return self
     */
    public function setMinPrice(?float $minPrice): self
    {
        $this->minPrice = $minPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getMaxPrice(): ?float
    {
        return $this->maxPrice;
    }

    /**
     * @param float $maxPrice
     *
     * @return self
     */
    public function setMaxPrice(?float $maxPrice): self
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getAveragePrice(): ?float
    {
        return $this->averagePrice;
    }

    /**
     * @param float $averagePrice
     *
     * @return self
     */
    public function setAveragePrice(?float $averagePrice): self
    {
        $this->averagePrice = $averagePrice;
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

    /**
     * @return CSTMSellProto[]
     */
    public function getSells(): ?array
    {
        return $this->sells;
    }

    /**
     * @param CSTMSellProto $sell
     *
     * @return self
     */
    public function addSell(?CSTMSellProto $sell): self
    {
        $this->sells[] = $sell;
        return $this;
    }
}
