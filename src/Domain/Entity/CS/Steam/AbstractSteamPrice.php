<?php

namespace App\Domain\Entity\CS\Steam;

use App\Domain\Entity\AbstractEntity;
use App\Domain\Entity\CS\CSItem;
use App\Domain\Traits\CreationDateTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 *
 * @ORM\MappedSuperclass()
 */
abstract class AbstractSteamPrice extends AbstractEntity
{
    use CreationDateTrait;

    /**
     * @var CSItem
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\CS\CSItem")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;

    /**
     * @var float
     *
     * @ORM\Column(name="lowest_price", type="float", nullable=false)
     */
    private $lowestPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="highest_price", type="float", nullable=false)
     */
    private $highestPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="average", type="float", nullable=false)
     */
    private $average;

    /**
     * @var float
     *
     * @ORM\Column(name="median", type="float", nullable=false)
     */
    private $median;

    /**
     * @var int
     *
     * @ORM\Column(name="sold", type="integer", nullable=false)
     */
    private $sold;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", nullable=false)
     */
    private $currency;

    /**
     * @return CSItem
     */
    public function getItem(): ?CSItem
    {
        return $this->item;
    }

    /**
     * @param CSItem $item
     *
     * @return self
     */
    public function setItem(?CSItem $item): self
    {
        $this->item = $item;
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
    public function getHighestPrice(): ?float
    {
        return $this->highestPrice;
    }

    /**
     * @param float $highestPrice
     *
     * @return self
     */
    public function setHighestPrice(?float $highestPrice): self
    {
        $this->highestPrice = $highestPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getAverage(): ?float
    {
        return $this->average;
    }

    /**
     * @param float $average
     *
     * @return self
     */
    public function setAverage(?float $average): self
    {
        $this->average = $average;
        return $this;
    }

    /**
     * @return float
     */
    public function getMedian(): ?float
    {
        return $this->median;
    }

    /**
     * @param float $median
     *
     * @return self
     */
    public function setMedian(?float $median): self
    {
        $this->median = $median;
        return $this;
    }

    /**
     * @return int
     */
    public function getSold(): ?int
    {
        return $this->sold;
    }

    /**
     * @param int $sold
     *
     * @return self
     */
    public function setSold(?int $sold): self
    {
        $this->sold = $sold;
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