<?php

namespace App\Orchid\Screens\Marketplace\Wildberries;

use App\ExternalApi\Wildberries\Repositories\WbRepository;
use App\Orchid\Screens\Marketplace\Wildberries\Layouts\MassActionsLayout;
use App\Orchid\Screens\Marketplace\Wildberries\Layouts\SalesStatisticLayout;
use App\Orchid\Screens\Marketplace\Wildberries\Layouts\SalesTableLayout;
use App\Repositories\WhiteListRepository;
use Illuminate\Http\Request;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Repository;

class WbMarketplaceListener extends Listener
{

    public static string $route;
    public static string $source;

    protected $targets = [
        'active.'
    ];

    protected function layouts(): iterable
    {
        return [
            SalesStatisticLayout::metrics(),
            MassActionsLayout::class,
            SalesTableLayout::class
        ];
    }

    public function handle(Repository $repository, Request $request): Repository
    {
        $data = $request->all();

        $path = route('platform.marketplace.wildberries');
        $params = ['id', 'value', 'method'];
        array_map(fn($param) => $request->request->remove($param),
            $params);

        $this->{$data['method']}($data);

        $repository->set('list',
            SalesTableLayout::query()
                ->paginate()
                ->withPath($path)
        )->set('sales',
            [
                'total' => SalesStatisticLayout::query()->count(),
                'latest' => SalesStatisticLayout::query()
                    ->whereDate('date', now()->subDay())
                    ->count(),
            ]
        );

        return $repository;
    }

    public function handleAttribute(array $data): void
    {
        $keyHash = WbRepository::getKeyHash();

        (bool)$data['value'] === true
            ? WhiteListRepository::add([$data['id']], $keyHash)
            : WhiteListRepository::remove([$data['id']], $keyHash);
    }

}
