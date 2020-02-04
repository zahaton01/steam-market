<?php

namespace App\Domain\Entity\Queue;

use App\Domain\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 *
 * @ORM\Table("cs_tm_item_decision_queue")
 * @ORM\Entity()
 */
class CSTMItemDecisionQueue extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="hash_name", type="string", nullable=false)
     */
    private $hashName;

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
}
