<?php

namespace App\Entity\CS\TM;

use App\Entity\AbstractEntity;
use App\Traits\CreationDateTrait;
use App\Traits\PriceTrait;
use App\Traits\SellDateTrait;
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
     * @ORM\ManyToOne(targetEntity="App\Entity\CS\TM\CSTMPricing", inversedBy="sells")
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