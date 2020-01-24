<?php

namespace App\Domain\Repository\CS;

use App\Domain\Tool\Pagination\Pagination;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class CSItemRepository extends EntityRepository
{
    /**
     * @param Pagination $pagination
     *
     * @return Paginator
     */
    public function getAllItems(Pagination $pagination): Paginator
    {
        $qb = $this->createQueryBuilder('i');

        $qb
            ->setFirstResult($pagination->getFirstResult())
            ->setMaxResults($pagination->getPageSize());

        return new Paginator($qb->getQuery(), true);
    }
}
