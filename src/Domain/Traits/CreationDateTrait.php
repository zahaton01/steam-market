<?php

namespace App\Domain\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
trait CreationDateTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=true)
     */
    private $creationDate;

    /**
     * @return \DateTime
     */
    public function getCreationDate(): ?\DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     *
     * @return self
     */
    public function setCreationDate(?\DateTime $creationDate): self
    {
        $this->creationDate = $creationDate;
        return $this;
    }
}
