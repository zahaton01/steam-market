<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 *
 * @ORM\MappedSuperclass()
 */
abstract class AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
