<?php

namespace App\Logs;

use App\Entity\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminLogService extends BaseLogService
{
    /**
     * @param string $message
     * @param array $extras
     * @param int $code
     * @return Log|mixed
     */
    public function info(string $message, array $extras = [], int $code = Response::HTTP_PROCESSING)
    {

        return $this->infoLog($message, Log::SOURCE_ADMIN, $extras, $code);
    }

    /**
     * @param string $message
     * @param array $extras
     * @param int $code
     * @return Log|mixed
     */
    public function warning(string $message, array $extras = [], int $code = Response::HTTP_PARTIAL_CONTENT)
    {
        return $this->warningLog($message, Log::SOURCE_ADMIN, $extras, $code);
    }

    /**
     * @param string $message
     * @param array $extras
     * @param int $code
     * @return Log|mixed
     */
    public function error(string $message, array $extras = [], int $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return $this->errorLog($message, Log::SOURCE_ADMIN, $extras, $code);
    }
}
