<?php

namespace App\Application\Logs\DB\Admin;

use App\Application\Logs\DB\AbstractDBLogger;
use App\Domain\Entity\Log;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class AdminDBLogger extends AbstractDBLogger
{
    /**
     * @param string $message
     * @param array $extras
     *
     * @return Log|mixed
     */
    public function info(string $message, array $extras = [])
    {
        return $this->infoLog($message, Log::SOURCE_ADMIN, $extras);
    }

    /**
     * @param string $message
     * @param array $extras
     *
     * @return Log|mixed
     */
    public function warning(string $message, array $extras = [])
    {
        return $this->warningLog($message, Log::SOURCE_ADMIN, $extras);
    }

    /**
     * @param string $message
     * @param array $extras
     *
     * @return Log|mixed
     */
    public function error(string $message, array $extras = [])
    {
        return $this->errorLog($message, Log::SOURCE_ADMIN, $extras);
    }
}
