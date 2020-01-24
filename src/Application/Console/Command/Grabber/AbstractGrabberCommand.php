<?php

namespace App\Application\Console\Command\Grabber;

use App\Application\Console\Command\AbstractCommand;
use App\Domain\Entity\CS\CSItem;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
abstract class AbstractGrabberCommand extends AbstractCommand
{
    /**
     * @param string $hashName
     * @param string $class
     *
     * @return bool
     */
    protected function doesItemExist(string $hashName, string $class)
    {
        $item = $this->manager->getEntityManager()->getRepository($class)->findOneBy(['hashName' => $hashName]);

        if (null === $item) {
            return false;
        }

        return true;
    }
}
