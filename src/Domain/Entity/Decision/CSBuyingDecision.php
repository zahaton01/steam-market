<?php

namespace App\Domain\Entity\Decision;

use App\Domain\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 *
 * @ORM\Table("cs_buying_decisions")
 * @ORM\Entity()
 */
class CSBuyingDecision extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="hash_name", type="string", nullable=true)
     */
    private $hashName;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", nullable=true)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="instance", type="string", nullable=false)
     */
    private $instance;

    /**
     * @var float
     *
     * @ORM\Column(name="min_sell_price", type="float", nullable=true)
     */
    private $minSellPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="buy_price", type="float", nullable=true)
     */
    private $buyPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="decline_reason", type="string", nullable=true)
     */
    private $declineReason;

    /**
     * @return string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return self
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
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
     * @return string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return self
     */
    public function setLink(?string $link): self
    {
        $this->link = $link;
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
     * @return float
     */
    public function getBuyPrice(): ?float
    {
        return $this->buyPrice;
    }

    /**
     * @param float $buyPrice
     *
     * @return self
     */
    public function setBuyPrice(?float $buyPrice): self
    {
        $this->buyPrice = $buyPrice;
        return $this;
    }

    /**
     * @return string
     */
    public function getDeclineReason(): ?string
    {
        return $this->declineReason;
    }

    /**
     * @param string $declineReason
     *
     * @return self
     */
    public function setDeclineReason(?string $declineReason): self
    {
        $this->declineReason = $declineReason;
        return $this;
    }
}
