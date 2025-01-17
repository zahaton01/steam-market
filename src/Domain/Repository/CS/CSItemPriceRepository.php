<?php

namespace App\Domain\Repository\CS;

use App\Domain\Entity\CS\Steam\AbstractSteamPrice;
use Doctrine\ORM\EntityRepository;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class CSItemPriceRepository extends EntityRepository
{
    /**
     * @param string $hashName
     *
     * @return AbstractSteamPrice|null
     */
    public function getLast(string $hashName)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->leftJoin('p.item', 'item')
            ->where('item.hashName = :hash_name')
            ->setParameter('hash_name', $hashName)
            ->orderBy('p.creationDate', 'DESC');

        return $qb->getQuery()->getResult()[0] ?? null;
    }
}
