<?php

namespace App\Domain\Query;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
abstract class AbstractQueryFilter
{
    /** @var string  */
    protected $value;

    /**
     * QueryFilter constructor.
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }

    /**
     * @return string|null
     */
    public function string(): ?string
    {
        return (string) $this->value;
    }

    /**
     * @return int
     */
    public function int()
    {
        return (int) $this->value;
    }

    /**
     * @return float
     */
    public function float()
    {
        return (float) $this->value;
    }
}