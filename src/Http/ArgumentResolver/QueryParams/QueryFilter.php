<?php

namespace App\Http\ArgumentResolver\QueryParams;

class QueryFilter
{
    /** @var string  */
    protected $value;

    /**
     * QueryFilter constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function formatted(): ?string
    {
        return mb_strtolower(trim($this->value));
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
