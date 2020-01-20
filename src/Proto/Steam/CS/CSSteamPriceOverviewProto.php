<?php

namespace App\Proto\Steam\CS;

use App\Proto\AbstractProto;
use App\Proto\JSONProto;
use App\Util\TextUtil;

class CSSteamPriceOverviewProto extends AbstractProto
{
    /** @var float */
    private $lowestPrice;
    /** @var float */
    private $medianPrice;

    /**
     * CSSteamPriceOverviewProto constructor.
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
     * @param array $params
     *
     * @return $this|mixed
     */
    public function init($data = null, array $params = [])
    {
        if (null === $data && $this->hasProto()) {
            $this->lowestPrice = (float) TextUtil::replaceCommas($this->getProto()->getDecodedJson()['lowest_price']);
            $this->medianPrice = (float) TextUtil::replaceCommas($this->getProto()->getDecodedJson()['median_price']);
        }

        return $this;
    }

    /**
     * @return float
     */
    public function getLowestPrice(): ?float
    {
        return $this->lowestPrice;
    }

    /**
     * @param float $lowestPrice
     *
     * @return self
     */
    public function setLowestPrice(?float $lowestPrice): self
    {
        $this->lowestPrice = $lowestPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getMedianPrice(): ?float
    {
        return $this->medianPrice;
    }

    /**
     * @param float $medianPrice
     *
     * @return self
     */
    public function setMedianPrice(?float $medianPrice): self
    {
        $this->medianPrice = $medianPrice;
        return $this;
    }
}
