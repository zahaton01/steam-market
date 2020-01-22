<?php

namespace App\Domain\Entity\CS\TM;

use App\Domain\Entity\AbstractEntity;
use App\Domain\Traits\CreationDateTrait;
use App\Domain\Traits\PriceTrait;
use App\Domain\Traits\SellDateTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CSTMSell
 * @package App\Entity\CS\TM
 *
 * @ORM\Table("tm_cs_sells")
 * @ORM\Entity()
 */
class CSTMSell extends AbstractEntity
{
    use SellDateTrait;
    use CreationDateTrait;
    use PriceTrait;

    /**
     * @var CSTMPricing
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\CS\TM\CSTMPricing", inversedBy="sells")
     * @ORM\JoinColumn(name="pricing_id", referencedColumnName="id")
     */
    private $pricing;

    /**
     * @return CSTMPricing
     */
    public function getPricing(): ?CSTMPricing
    {
        return $this->pricing;
    }

    /**
     * @param CSTMPricing $pricing
     *
     * @return self
     */
    public function setPricing(?CSTMPricing $pricing): self
    {
        $this->pricing = $pricing;
        return $this;
    }
}
