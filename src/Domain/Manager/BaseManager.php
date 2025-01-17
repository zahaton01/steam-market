<?php

namespace App\Domain\Manager;

use Doctrine\ORM\EntityManagerInterface;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class BaseManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * BaseManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $content
     * @return mixed
     */
    public function save($content)
    {
        if (is_iterable($content)) {
            foreach ($content as $item) {
                $this->em->persist($item);
            }

            $this->em->flush();
            return true;
        }

        $this->em->persist($content);
        $this->em->flush();

        return $content;
    }

    /**
     * @param $content
     * @return null
     */
    public function remove($content)
    {
        if (is_iterable($content)) {
            foreach ($content as $item) {
                $this->em->remove($item);
            }

            $this->em->flush();
            return null;
        }

        $this->em->remove($content);
        $this->em->flush();

        return null;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }
}
