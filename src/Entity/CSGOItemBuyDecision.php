<?php

namespace App\Entity;

use App\Model\Decision;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CSGOItemBuyDecision
 * @package App\Entity
 *
 * @ORM\Table("cs_go_items_buy_decisions")
 * @ORM\Entity()
 */
class CSGOItemBuyDecision
{
    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="hash_name", type="string", nullable=false)
     */
    private $hashName;

    /**
     * @var float
     *
     * @ORM\Column(name="steam_price", type="float", nullable=false)
     */
    private $steamPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="market_price", type="float", nullable=false)
     */
    private $marketPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="min_sell_price", type="float", nullable=false)
     */
    private $minSellPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", nullable=false)
     */
    private $currency;

    /**
     * @var Decision
     *
     * @ORM\Column(name="decision", type="json", nullable=false)
     */
    private $decision;

    /**
     * @var string
     *
     * @ORM\Column(name="instance", type="string", nullable=false)
     */
    private $instance;

    /**
     * @var string
     *
     * @ORM\Column(name="steam_marketplace_url", type="string", nullable=false)
     */
    private $steamMarketplaceUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="tm_marketplace_url", type="string", nullable=false)
     */
    private $tmMarketplaceUrl;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHashName(): ?string
    {
        return $this->hashName;
    }

    /**
     * @param string $hashName
     *
     * @return self
     */
    public function setHashName(?string $hashName): self
    {
        $this->hashName = $hashName;
        return $this;
    }

    /**
     * @return float
     */
    public function getSteamPrice(): ?float
    {
        return $this->steamPrice;
    }

    /**
     * @param float $steamPrice
     *
     * @return self
     */
    public function setSteamPrice(?float $steamPrice): self
    {
        $this->steamPrice = $steamPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getMarketPrice(): ?float
    {
        return $this->marketPrice;
    }

    /**
     * @param float $marketPrice
     *
     * @return self
     */
    public function setMarketPrice(?float $marketPrice): self
    {
        $this->marketPrice = $marketPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getMinSellPrice(): ?float
    {
        return $this->minSellPrice;
    }

    /**
     * @param float $minSellPrice
     *
     * @return self
     */
    public function setMinSellPrice(?float $minSellPrice): self
    {
        $this->minSellPrice = $minSellPrice;
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
     * @return Decision|null
     */
    public function getDecision(): ?Decision
    {
        $decision = new Decision();
        $decision
            ->setStatus($this->decision['status'])
            ->setMessage($this->decision['message']);

        return $decision;
    }

    /**
     * @param Decision $decision
     *
     * @return self
     */
    public function setDecision(Decision $decision): self
    {
        $data = [
            'status' => $decision->getStatus(),
            'message' => $decision->getMessage()
        ];

        $this->decision = $data;

        return $this;
    }

    /**
     * @return string
     */
    public function getInstance(): ?string
    {
        return $this->instance;
    }

    /**
     * @param string $instance
     *
     * @return self
     */
    public function setInstance(?string $instance): self
    {
        $this->instance = $instance;
        return $this;
    }

    /**
     * @return string
     */
    public function getSteamMarketplaceUrl(): ?string
    {
        return $this->steamMarketplaceUrl;
    }

    /**
     * @param string $steamMarketplaceUrl
     *
     * @return self
     */
    public function setSteamMarketplaceUrl(?string $steamMarketplaceUrl): self
    {
        $this->steamMarketplaceUrl = $steamMarketplaceUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getTmMarketplaceUrl(): ?string
    {
        return $this->tmMarketplaceUrl;
    }

    /**
     * @param string $tmMarketplaceUrl
     *
     * @return self
     */
    public function setTmMarketplaceUrl(?string $tmMarketplaceUrl): self
    {
        $this->tmMarketplaceUrl = $tmMarketplaceUrl;
        return $this;
    }
}
