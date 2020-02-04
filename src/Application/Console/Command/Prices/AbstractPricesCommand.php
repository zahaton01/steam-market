<?php

namespace App\Application\Console\Command\Prices;

use App\Application\Console\Command\AbstractCommand;
use App\Domain\Entity\Queue\CSTMItemDecisionQueue;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
abstract class AbstractPricesCommand extends AbstractCommand
{
    /**
     * @param string $hashName
     *
     * @return bool
     */
    protected function inCSTMDecisionQueue(string $hashName)
    {
        $item = $this->manager->getEntityManager()->getRepository(CSTMItemDecisionQueue::class)->findOneBy(['hashName' => $hashName]);

        if (null === $item) {
            return false;
        }

        return true;
    }
}
