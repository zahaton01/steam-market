<?php

namespace App\Application\Resources\Proto;

use App\Application\Resources\Proto\Exception\MissingProtoFieldException;
use App\Application\Service\Client\JSON\Proto\JsonProto;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
abstract class AbstractProto
{
    /** @var JsonProto  */
    private $proto;

    /**
     * AbstractProto constructor.
     * @param JsonProto $proto
     *
     * @throws MissingProtoFieldException
     */
    public function __construct(JsonProto $proto)
    {
        $this->proto = $proto;
        $this->__invoke();
    }

    /**
     * @return JsonProto
     */
    public function getProto(): ?JsonProto
    {
        return $this->proto;
    }

    /**
     * Returns model which represents data from JsonProto
     *
     * @return mixed
     *
     * @throws MissingProtoFieldException
     */
    abstract function __invoke();

    /**
     * Validates json proto before invoke
     *
     * @return bool
     */
    abstract function validate(): bool;
}
