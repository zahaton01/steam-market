<?php

namespace App\Application\Resources\API\Steam\Proto\PriceOverview;

use App\Application\Resources\Proto\AbstractProto;
use App\Application\Resources\Proto\Exception\MissingProtoFieldException;
use App\Application\Util\TextUtil;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class PriceOverviewProto extends AbstractProto
{
    /** @var float */
    private $lowestPrice;
    /** @var float */
    private $medianPrice;

    /**
     * @return $this
     *
     * @throws MissingProtoFieldException
     */
    public function __invoke()
    {
        $json = $this->getProto()->getDecodedJson();

        if ($this->validate()) {
            $this->lowestPrice = (float) TextUtil::replaceCommas($json['lowest_price']);
            $this->medianPrice = (float) TextUtil::replaceCommas($json['median_price']);
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

        if (!isset($json['lowest_price']))
            throw new MissingProtoFieldException('Lowest price is missing in Json Proto');

        if (!isset($json['median_price']))
            throw new MissingProtoFieldException('Median price is missing in Json Proto');

        return true;
    }

    /**
     * @return float
     */
    public function getLowestPrice(): ?float
    {
        return $this->lowestPrice;
    }

    /**
     * @return float
     */
    public function getMedianPrice(): ?float
    {
        return $this->medianPrice;
    }
}
