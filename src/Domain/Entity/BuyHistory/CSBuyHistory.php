<?php

namespace App\Domain\Entity\BuyHistory;

use App\Domain\Entity\AbstractEntity;
use App\Domain\Entity\Decision\CSBuyingDecision;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 *
 * @ORM\Table("cs_tm_buy_history")
 * @ORM\Entity()
 */
class CSBuyHistory extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="custom_id", type="string", nullable=false)
     */
    private $customId;

    /**
     * @var string
     *
     * @ORM\Column(name="item_id", type="string", nullable=false)
     */
    private $itemId;

    /**
     * @var CSBuyingDecision
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Entity\Decision\CSBuyingDecision")
     * @ORM\JoinColumn(name="decision_id", referencedColumnName="id")
     */
    private $decision;

    /**
     * @return string
     */
    public function getCustomId(): ?string
    {
        return $this->customId;
    }

    /**
     * @param string $customId
     *
     * @return self
     */
    public function setCustomId(?string $customId): self
    {
        $this->customId = $customId;
        return $this;
    }

    /**
     * @return string
     */
    public function getItemId(): ?string
    {
        return $this->itemId;
    }

    /**
     * @param string $itemId
     *
     * @return self
     */
    public function setItemId(?string $itemId): self
    {
        $this->itemId = $itemId;
        return $this;
    }

    /**
     * @return CSBuyingDecision
     */
    public function getDecision(): ?CSBuyingDecision
    {
        return $this->decision;
    }

    /**
     * @param CSBuyingDecision $decision
     *
     * @return self
     */
    public function setDecision(?CSBuyingDecision $decision): self
    {
        $this->decision = $decision;
        return $this;
    }
}
