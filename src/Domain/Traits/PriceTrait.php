<?php

namespace App\Domain\Traits;

trait PriceTrait
{
    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", nullable=false)
     */
    private $currency;

    /**
     * @return float
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return self
     */
    public function setPrice(?float $price): self
    {
        $this->price = $price;
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
