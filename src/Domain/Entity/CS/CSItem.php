<?php

namespace App\Domain\Entity\CS;

use App\Domain\Entity\AbstractEntity;
use App\Domain\Entity\CS\TM\CSTMPricing;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 *
 * @ORM\Table("steam_cs_items")
 * @ORM\Entity(repositoryClass="App\Domain\Repository\CS\CSItemRepository")
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
     * @ORM\OneToMany(targetEntity="App\Domain\Entity\CS\TM\CSTMPricing", mappedBy="item")
     */
    private $tmSells;

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
     * @return bool
     */
    public function isAllowedForBuying(): ?bool
    {
        return $this->isAllowedForBuying;
    }

    /**
     * @param bool $isAllowedForBuying
     *
     * @return self
     */
    public function setIsAllowedForBuying(?bool $isAllowedForBuying): self
    {
        $this->isAllowedForBuying = $isAllowedForBuying;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAllowedForSelling(): ?bool
    {
        return $this->isAllowedForSelling;
    }

    /**
     * @param bool $isAllowedForSelling
     *
     * @return self
     */
    public function setIsAllowedForSelling(?bool $isAllowedForSelling): self
    {
        $this->isAllowedForSelling = $isAllowedForSelling;
        return $this;
    }

    /**
     * @return string
     */
    public function getSteamLink(): ?string
    {
        return $this->steamLink;
    }

    /**
     * @param string $steamLink
     *
     * @return self
     */
    public function setSteamLink(?string $steamLink): self
    {
        $this->steamLink = $steamLink;
        return $this;
    }

    /**
     * @return PersistentCollection
     */
    public function getTmSells(): ?PersistentCollection
    {
        return $this->tmSells;
    }

    /**
     * @param CSTMPricing $tmSell
     *
     * @return self
     */
    public function addTmSell(CSTMPricing $tmSell): self
    {
        $this->tmSells[] = $tmSell;
        return $this;
    }
}
