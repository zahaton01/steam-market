<?php

namespace App\Entity\CS;

use App\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Class CSItem
 * @package App\Entity\CS
 *
 * @ORM\Table("steam_cs_items")
 * @ORM\Entity()
 */
class CSItem extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="hash_name", type="string", nullable=false)
     */
    private $hashName;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_allowed_for_buying", type="boolean", nullable=false)
     */
    private $isAllowedForBuying;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_allowed_for_selling", type="boolean", nullable=false)
     */
    private $isAllowedForSelling;

    /**
     * @var string
     *
     * @ORM\Column(name="steam_link", type="string", nullable=false)
     */
    private $steamLink;

    /**
     * @var PersistentCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\CS\Steam\CSSteamPrice", mappedBy="item")
     */
    private $steamPrices;

    /**
     * @var PersistentCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\CS\Steam\CSSteamSell", mappedBy="item")
     */
    private $steamSells;

    /**
     * @var PersistentCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\CS\TM\CSTMPricing", mappedBy="item")
     */
    private $tmSells;
}