<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractEntity
 * @package App\Entity
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
