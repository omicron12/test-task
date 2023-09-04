<?php

declare(strict_types=1);

namespace App\Orchid\Filters\Types;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\BaseHttpEloquentFilter;

class Where extends BaseHttpEloquentFilter
{
    public function run(Builder $builder): Builder
    {
        $table = $builder->getModel()->getTable();
        return $builder->where("$table.$this->column", $this->getHttpValue());
    }
}
