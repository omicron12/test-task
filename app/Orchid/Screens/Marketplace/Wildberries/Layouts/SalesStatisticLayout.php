<?php

namespace App\Orchid\Screens\Marketplace\Wildberries\Layouts;

use App\ExternalApi\Wildberries\Repositories\WbRepository;
use App\Models\Sale;
use Orchid\Support\Facades\Layout;

class SalesStatisticLayout
{
    public static function metrics()
    {
        return [
            Layout::columns([
                Layout::view('platform::layouts.metric_with_action', [
                    'name' => 'Всего продаж',
                    'key' => 'sales',
                    'value' => 'total',
                    'action' => [
                        'name' => 'link',
                        'label' => 'Скачать',
                        'url' => route('sales.download', [
                            'marketplace' => WbRepository::MARKETPLACE
                        ])
                    ]
                ]),
                Layout::view('platform::layouts.metric_with_action', [
                    'name' => 'Последние продажи',
                    'key' => 'sales',
                    'value' => 'latest',
                    'action' => [
                        'name' => 'link',
                        'label' => 'Скачать',
                        'url' => route('sales.download', [
                            'marketplace' => WbRepository::MARKETPLACE,
                            'date' => now()->subDay()->format('Y-m-d')
                        ])
                    ]
                ]),
            ]),
        ];
    }

    public static function query()
    {
        return Sale::withKey(WbRepository::getKeyHash())->active();
    }

}
