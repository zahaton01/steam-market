<?php

namespace App\Model;

class Decision
{
    /** @var string */
    private $message;
    /** @var boolean */
    private $status;
    /** @var float */
    private $minSellPrice;

    /**
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return self
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return bool
     */
    public function getStatus(): ?bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     *
     * @return self
     */
    public function setStatus(?bool $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->status === true;
    }

    /**
     * @return float
     */
    public function getMinSellPrice(): ?float
    {
        return $this->minSellPrice;
    }

    /**
     * @param float $minSellPrice
     *
     * @return self
     */
    public function setMinSellPrice(?float $minSellPrice): self
    {
        $this->minSellPrice = $minSellPrice;
        return $this;
    }
}
