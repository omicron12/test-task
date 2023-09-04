<?php

namespace App\Orchid\Screens\Marketplace\Wildberries;

use App\ExternalApi\Wildberries\Repositories\WbRepository;
use App\Models\Sale;
use App\Orchid\Screens\Marketplace\Wildberries\Layouts\SalesStatisticLayout;
use App\Orchid\Screens\Marketplace\Wildberries\Layouts\SalesTableLayout;
use App\Repositories\WhiteListRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Orchid\Screen\Screen;

class WbMarketplaceScreen extends Screen
{
    private LengthAwarePaginator $paginateItems;

    public function __construct()
    {

    }

    public function query(): iterable
    {
        $this->paginateItems = SalesTableLayout::query()->paginate();

        return [
            'list' => $this->paginateItems,
            'filter' => ['filter' => request()->get('filter')],
            'sales' => [
                'total' =>  SalesStatisticLayout::query()->count(),
                'latest' => SalesStatisticLayout::query()
                    ->whereDate('date', now()->subDay())
                    ->count(),
            ],
        ];
    }

    public function name(): ?string
    {
        return 'Фильтр продаж';
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        return [
            WbMarketplaceListener::class
        ];
    }

    public function addSelected(): void
    {
        $this->applyFilter();

        WhiteListRepository::add(
            SalesTableLayout::query()->get()->pluck('article'),
            WbRepository::getKeyHash()
        );
    }

    public function removeSelected(): void
    {
        $this->applyFilter();

        WhiteListRepository::remove(
            SalesTableLayout::query()->get()->pluck('article'),
            WbRepository::getKeyHash()
        );
    }

    public function applyFilter(): void
    {
        $filter = $this->extractState()->get('filter', []);
        request()->merge($filter);
    }

}
