<?php

namespace App\Orchid\Screens\Marketplace\Wildberries\Layouts;

use App\ExternalApi\Wildberries\Repositories\WbRepository;
use App\Models\Sale;
use App\Orchid\Screens\Marketplace\Filters\SaleDateFilter;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SalesTableLayout extends Table
{
    protected $target = 'list';

    protected function columns(): iterable
    {
        return [
            TD::make('active', __('Включен'))
                ->filter(Select::make()
                    ->options([
                        'Включен' => 'Включен',
                        'Выключен' => 'Выключен',
                    ])->empty('Не выбрано')
                )
                ->render(function (Sale $item) {
                    return CheckBox::make('active[]')
                        ->set('data-single', 'true')
                        ->set('data-method', 'handleAttribute')
                        ->set('data-id', $item->article)
                        ->checked((bool)$item->active);
                }),
            TD::make('article', __('Артикул'))->filter(),
            TD::make('barcode', __('Штрих-код'))->filter(),
            TD::make('subject', __('Название'))->filter(),
            TD::make('category', __('Категория'))->filter(),
            TD::make('brand', __('Бренд'))->filter(),
        ];
    }

    public static function query()
    {
        return Sale::withKey(WbRepository::getKeyHash())
            ->filters()
            ->filtersApply([
                SaleDateFilter::class
            ])
            ->where('source', WbRepository::class)
            ->groupBy('sales.article')
            ->orderByDesc('date');
    }

}
