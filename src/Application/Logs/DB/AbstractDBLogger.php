<?php

namespace App\Application\Logs\DB;

use App\Domain\Entity\Log;
use App\Domain\Factory\Log\LogFactory;
use App\Domain\Manager\BaseManager;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
abstract class AbstractDBLogger
{
    /** @var LogFactory */
    private $logFactory;
    /** @var BaseManager */
    private $manager;

    /**
     * BaseLogService constructor.
     * @param LogFactory $logFactory
     * @param BaseManager $bm
     */
    public function __construct(LogFactory $logFactory, BaseManager $bm)
    {
        $this->logFactory = $logFactory;
        $this->manager = $bm;
    }

    /**
     * @param string $message
     * @param string $source
     * @param string $level
     * @param array $extras
     *
     * @return Log|mixed
     */
    private function createLog(
        string $message,
        string $source,
        string $level,
        array $extras = []
    ): Log {
        $log = $this->logFactory->createBasic(
            $message,
            $source,
            $level,
            $extras
        );

        return $this->manager->save($log);
    }

    /**
     * @param string $message
     * @param string $source
     * @param array $extras
     *
     * @return Log|mixed
     */
    protected function infoLog(
        string $message,
        string $source,
        array $extras = []
    ): Log {
        return $this->createLog($message, $source, Log::LEVEL_INFO, $extras);
    }

    /**
     * @param string $message
     * @param string $source
     * @param array $extras
     *
     * @return Log|mixed
     */
    protected function warningLog(
        string $message,
        string $source,
        array $extras = []
    ): Log {
        return $this->createLog($message, $source, Log::LEVEL_WARNING, $extras);
    }

    /**
     * @param string $message
     * @param string $source
     * @param array $extras
     *
     * @return Log|mixed
     */
    protected function errorLog(
        string $message,
        string $source,
        array $extras = []
    ): Log {
        return $this->createLog($message, $source, Log::LEVEL_ERROR, $extras);
    }
}
