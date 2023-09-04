<?php

declare(strict_types=1);

namespace App\Orchid\Filters\Types;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\BaseHttpEloquentFilter;

class ActiveFilter extends BaseHttpEloquentFilter
{
    public function run(Builder $builder): Builder
    {
        return $builder->where('active', $this->getHttpValue() === __('Включен'));
    }
}
