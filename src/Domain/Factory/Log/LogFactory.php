<?php

namespace App\Domain\Factory\Log;

use App\Domain\Entity\Log;
use App\Domain\Factory\AbstractFactory;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class LogFactory extends AbstractFactory
{
    /**
     * @param string $message
     * @param string $source
     * @param string $level
     * @param array $extras
     *
     * @return Log
     */
    public function createBasic(
        string $message,
        string $source,
        string $level,
        array $extras = []
    ): Log {
        $log = new Log();
        $log
            ->setMessage($message)
            ->setSource($source)
            ->setExtras($extras)
            ->setLevel($level)
            ->setCreationDate($this->getCurrentDate());

        return $log;
    }

    /**
     * @return Log
     */
    public function createEmpty(): Log
    {
        return new Log();
    }
}
