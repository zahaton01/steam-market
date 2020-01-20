<?php

namespace App\Entity\CS\Steam;

use App\Entity\AbstractEntity;
use App\Entity\CS\CSItem;
use App\Traits\CreationDateTrait;
use App\Traits\PriceTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CSSteamPrice
 * @package App\Entity\CS\Steam
 *
 * @ORM\Table("steam_cs_prices")
 * @ORM\Entity()
 */
class CSSteamPrice extends AbstractEntity
{
    use CreationDateTrait;
    use PriceTrait;

    /**
     * @var float
     *
     * @ORM\Column(name="median_price", type="float", nullable=false)
     */
    private $medianPrice;

    /**
     * @var CSItem
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\CS\CSItem", inversedBy="steamPrices")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;

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
}
