<?php

namespace App\Entity\CS\Steam;

use App\Entity\AbstractEntity;
use App\Entity\CS\CSItem;
use App\Traits\CreationDateTrait;
use App\Traits\PriceTrait;
use App\Traits\SellDateTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CSSteamSell
 * @package App\Entity\CS\Steam
 *
 * @ORM\Table("steam_cs_sells")
 * @ORM\Entity()
 */
class CSSteamSell extends AbstractEntity
{
    use CreationDateTrait;
    use SellDateTrait;
    use PriceTrait;

    /**
     * @var CSItem
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\CS\CSItem", inversedBy="steamSells")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

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
     * @return int
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return self
     */
    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }
}