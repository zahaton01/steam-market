<?php

namespace App\Logs;

use App\Factory\LogFactory;
use App\Manager\BaseManager;
use App\Entity\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BaseLogService
 * @package AppBundle\Logs
 */
class BaseLogService
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
     * @param int $code
     *
     * @return Log|mixed
     */
    private function createLog(
        string $message,
        string $source,
        string $level,
        array $extras = [],
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR
    ) {
        $log = $this->logFactory->createBasic(
            $message,
            $source,
            $level,
            $extras,
            $code
        );

        $log = $this->manager->save($log);

        return $log;
    }

    /**
     * @param string $message
     * @param string $source
     * @param array $extras
     * @param int $code
     * @return Log|mixed
     */
    protected function infoLog(
        string $message,
        string $source = Log::SOURCE_COMMAND,
        array $extras = [],
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR
    ) {
        return $this->createLog($message, $source, Log::LEVEL_INFO, $extras, $code);
    }

    /**
     * @param string $message
     * @param string $source
     * @param array $extras
     * @param int $code
     * @return Log|mixed
     */
    protected function warningLog(
        string $message,
        string $source = Log::SOURCE_COMMAND,
        array $extras = [],
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR
    ) {
        return $this->createLog($message, $source, Log::LEVEL_WARNING, $extras, $code);
    }

    /**
     * @param string $message
     * @param string $source
     * @param array $extras
     * @param int $code
     * @return Log|mixed
     */
    protected function errorLog(
        string $message,
        string $source = Log::SOURCE_COMMAND,
        array $extras = [],
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR
    ) {
        return $this->createLog($message, $source, Log::LEVEL_ERROR, $extras, $code);
    }
}
