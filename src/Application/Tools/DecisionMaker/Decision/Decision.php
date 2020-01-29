<?php

namespace App\Application\Tools\DecisionMaker\Decision;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class Decision implements DecisionInterface
{
    /** @var bool */
    private $status;
    /** @var DecisionResultInterface */
    private $result;

    /**
     * @return bool
     */
    public function isApproved(): bool
    {
        return true === $this->status;
    }

    /**
     * @return bool
     */
    public function isDeclined(): bool
    {
        return false === $this->status;
    }

    /**
     * @param bool $status
     *
     * @return self
     */
    public function setStatus(?bool $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return DecisionResultInterface
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param DecisionResultInterface $result
     *
     * @return self
     */
    public function setResult(?DecisionResultInterface $result): self
    {
        $this->result = $result;
        return $this;
    }
}