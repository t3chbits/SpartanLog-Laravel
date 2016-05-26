<?php

namespace App\Api\V1\Macros;

use Illuminate\Database\Query\Builder;

// This is used to add optional orderBy conditions.
// This seemed to be a more concise solution compared
// to using the when method.
Builder::macro('orderByIf', function ($column, $direction) {
    if($column) {
        return $this->orderBy($column, $direction);
    }
    return $this;
});