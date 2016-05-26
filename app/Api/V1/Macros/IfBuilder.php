<?php

namespace App\Api\V1\Macros;

use Illuminate\Database\Query\Builder;

// This is used to add optional query statements.
// This seemed to be a more concise solution compared
// to using the when method.
Builder::macro('if', function ($condition, $column, $operator, $value) {
    if($condition) {
        return $this->where($column, $operator, $value);
    }
    return $this;
});