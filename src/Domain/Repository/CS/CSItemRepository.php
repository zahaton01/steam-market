<?php

namespace App\Domain\Repository\CS;

use App\Model\Pagination\Pagination;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CSItemRepository extends EntityRepository
{
    /**
     * @param Pagination $pagination
     * @param bool|null $isEnabledForBuying
     *
     * @return Paginator
     */
    public function getAllItems(Pagination $pagination, bool $isEnabledForBuying = null): Paginator
    {
        $qb = $this->createQueryBuilder('i');

        if (null !== $isEnabledForBuying) {
            $qb
                ->andWhere('i.isAllowedForBuying = :is_allowed_for_buying')
                ->setParameter('is_allowed_for_buying', $isEnabledForBuying ? 1 : 0);
        }

        $qb
            ->setFirstResult($pagination->getFirstResult())
            ->setMaxResults($pagination->getPageSize());

        return new Paginator($qb->getQuery(), true);
    }
}
