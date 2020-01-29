<?php

namespace App\Application\Resources\API\TM\Proto\Sells;

use App\Application\Resources\API\TM\Proto\Sells\Model\TMPricing;
use App\Application\Resources\API\TM\Proto\Sells\Model\TMSell;
use App\Application\Resources\Proto\AbstractProto;
use App\Application\Resources\Proto\Exception\MissingProtoFieldException;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class TMPricingProto extends AbstractProto
{
    /** @var string */
    private $currency;
    /** @var TMPricing[] */
    private $pricings;

    public function __invoke()
    {
        if ($this->validate()) {
            $json = $this->getProto()->getDecodedJson();
            $this->currency = $json['currency'] ?? null;

            foreach ($json['data'] as $hashName => $data) {
                $tmPricing = new TMPricing();
                $tmPricing
                    ->setHashName($hashName)
                    ->setAverage($data['average'])
                    ->setMinPrice($data['min'])
                    ->setMaxPrice($data['max']);

                foreach ($data['history'] as $sell) {
                    $tmPricing->addSell(
                        (new TMSell())
                        ->setPrice($sell[1])
                        ->setSellDate((new \DateTime('now'))->setTimestamp($sell[0]))
                    );
                }

                $this->pricings[] = $tmPricing;
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

        if (!isset($json['data']) || !count($json['data']))
            throw new MissingProtoFieldException('Items are missing in Json Proto');

        return true;
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
     * @return TMPricing[]
     */
    public function getPricings(): ?array
    {
        return $this->pricings;
    }

    /**
     * @param TMPricing $pricing
     *
     * @return self
     */
    public function addPricing(TMPricing $pricing): self
    {
        $this->pricings[] = $pricing;
        return $this;
    }
}