<?php

namespace App\Model\Steam\CSGO;

class SteamCSGOItem
{
    /** @var float */
    private $lowestPrice;
    /** @var float */
    private $medianPrice;
    /** @var string */
    private $marketplaceUrl;
    /** @var string */
    private $currency;
    /** @var string */
    private $steamCurrency;

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

    /**
     * @return string
     */
    public function getMarketplaceUrl(): ?string
    {
        return $this->marketplaceUrl;
    }

    /**
     * @param string $marketplaceUrl
     *
     * @return self
     */
    public function setMarketplaceUrl(?string $marketplaceUrl): self
    {
        $this->marketplaceUrl = $marketplaceUrl;
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
     * @return string
     */
    public function getSteamCurrency(): ?string
    {
        return $this->steamCurrency;
    }

    /**
     * @param string $steamCurrency
     *
     * @return self
     */
    public function setSteamCurrency(?string $steamCurrency): self
    {
        $this->steamCurrency = $steamCurrency;
        return $this;
    }
}
