<?php

namespace App\Repository;

use App\Domain\Entity\Log;
use App\Model\Pagination\Pagination;
use App\Model\Query\QueryParams;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

class LogRepository extends EntityRepository
{
    /**
     * @param QueryParams $params
     * @return Query
     */
    public function findByQuery(QueryParams $params): Query
    {
        $qb = $this->createQueryBuilder('l');
        $qb
            ->orderBy('l.creationDate', 'DESC');

        if ($params->hasStartDate()) {
            $qb
                ->andWhere('l.creationDate >= :startDate')
                ->setParameter('startDate', $params->getStartDate());
        }

        if ($params->hasEndDate()) {
            $qb
                ->andWhere('l.creationDate <= :endDate')
                ->setParameter('endDate', $params->getEndDate());
        }

        if ($params->hasFilter('source')) {
            $qb
                ->andWhere('l.source = :source')
                ->setParameter('source', $params->getFilter('source')->getValue());
        }

        if ($params->hasFilter('level')) {
            $qb
                ->andWhere('l.level = :level')
                ->setParameter('level', $params->getFilter('level')->getValue());
        }

        return $qb->getQuery();
    }


    /**
     * @param Pagination $pagination
     * @return mixed
     */
    public function getAllInfoAndWarnings(Pagination $pagination)
    {
        $qb = $this->createQueryBuilder('l');
        $qb->andWhere('l.level = :info or l.level = :warning');
        $qb->setParameters([
            'info' => Log::LEVEL_INFO,
            'warning' => Log::LEVEL_WARNING
        ]);

        $qb->setFirstResult($pagination->getFirstResult());
        $qb->setMaxResults($pagination->getPageSize());

        return new Paginator($qb->getQuery(), true);
    }

    /**
     * @param Pagination $pagination
     * @return Paginator
     */
    public function getAllLogs(Pagination $pagination)
    {
        $qb = $this->createQueryBuilder('l');
        $qb->select('l');

        $qb->setFirstResult($pagination->getFirstResult());
        $qb->setMaxResults($pagination->getPageSize());

        return new Paginator($qb->getQuery(), true);
    }
}
