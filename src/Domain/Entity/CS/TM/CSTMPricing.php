<?php

namespace App\Domain\Entity\CS\TM;

use App\Application\Resources\API\TM\Proto\Sells\Model\TMSell;
use App\Domain\Entity\AbstractEntity;
use App\Domain\Entity\CS\CSItem;
use App\Domain\Traits\CreationDateTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 *
 * @ORM\Table("tm_cs_pricings")
 * @ORM\Entity(repositoryClass="App\Domain\Repository\CS\CSTMPricingRepository")
 */
class CSTMPricing extends AbstractEntity
{
    use CreationDateTrait;

    /**
     * @var CSItem
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\CS\CSItem", inversedBy="tmSells")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;

    /**
     * @var float
     *
     * @ORM\Column(name="min_price", type="float", nullable=false)
     */
    private $minPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="max_price", type="float", nullable=false)
     */
    private $maxPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="average", type="float", nullable=false)
     */
    private $average;

    /**
     * @var PersistentCollection
     *
     * @ORM\OneToMany(targetEntity="App\Domain\Entity\CS\TM\CSTMSell", mappedBy="pricing", cascade={"persist", "remove"})
     */
    private $sells;

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
     * @return TMSell[]
     */
    public function getSells(): ?PersistentCollection
    {
        return $this->sells;
    }

    /**
     * @param CSTMSell $sell
     *
     * @return self
     */
    public function addSell(?CSTMSell $sell): self
    {
        $this->sells[] = $sell;
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
