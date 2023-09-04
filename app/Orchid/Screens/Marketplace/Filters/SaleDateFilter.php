<?php

namespace App\Orchid\Screens\Marketplace\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Fields\DateTimer;

class SaleDateFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Начиная с даты';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['dateFrom'];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('created_at', now());
    }

    public function display(): array
    {
        return [
            DateTimer::make('dateFrom')
                ->required()
                ->placeholder('Дата начала продаж')
                ->format('d-m-Y')
            ,
        ];
    }
}
