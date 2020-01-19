<?php

namespace App\Factory;

use App\Entity\Log;
use Symfony\Component\HttpFoundation\Response;

class LogFactory
{
    public function createBasic(
        string $message,
        string $source,
        string $level,
        array $extras = [],
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR
    ) {
        $log = new Log();
        $log
            ->setCode($code)
            ->setMessage($message)
            ->setSource($source)
            ->setExtras($extras)
            ->setLevel($level)
            ->setCreationDate(new \DateTime('now'))
        ;

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
