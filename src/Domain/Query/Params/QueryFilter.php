<?php

namespace App\Domain\Query\Params;

use App\Domain\Query\AbstractQueryFilter;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class QueryFilter extends AbstractQueryFilter
{
    /**
     * @return string|null
     */
    public function formatted(): ?string
    {
        return mb_strtolower(trim($this->value));
    }
}