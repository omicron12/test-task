<?php

namespace App\Orchid\Screens\Settings;

use App\Orchid\Screens\Settings\Layouts\WildberriesRow;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;

class Settings extends Screen
{
    public function query(): iterable
    {
        return [
            'api' => [
                'wildberries' => [
                    'key' => config('external-api.wildberries.key'),
                ],
            ],
        ];
    }

    public function name(): ?string
    {
        return 'Настройки интеграции';
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        return [
            Layouts\WildberriesRow::class,
        ];
    }

    public function saveSettings(Request $request): void
    {
        WildberriesRow::saveSettings($request);
    }

}
