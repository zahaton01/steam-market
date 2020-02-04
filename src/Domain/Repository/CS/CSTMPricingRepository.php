<?php

namespace App\Domain\Repository\CS;

use App\Domain\Entity\CS\TM\CSTMPricing;
use Doctrine\ORM\EntityRepository;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class CSTMPricingRepository extends EntityRepository
{
    /**
     * @param string $hashName
     *
     * @return CSTMPricing|null
     */
    public function getLastByHashName(string $hashName)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->leftJoin('p.item', 'item')
            ->leftJoin('p.sells', 'sells');

        $qb
            ->where('item.hashName = :hash_name')
                ->setParameter('hash_name', $hashName)
                    ->orderBy('p.creationDate', 'DESC');

        return $qb->getQuery()->getResult()[0] ?? null;
    }
}
