<?php

namespace App\Orchid\Screens\Settings\Layouts;

use App\ExternalApi\Wildberries\Events\UpdateWbRepositoryEvent;
use App\ExternalApi\Wildberries\Repositories\WbRepository;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class WildberriesRow extends Rows
{
    protected $title = 'Wildberries';
    private string $marketplace;

    public function __construct()
    {
        $this->marketplace = WbRepository::MARKETPLACE;
    }

    protected function fields(): iterable
    {
        return [
            Group::make([
                Input::make('api.wildberries.key')
                    ->required()
                    ->title('API Ключ')
                    ->horizontal()
                    ->popover('Ваш API ключ статистики из личного кабинета Wildberries'),
                Button::make('Сохранить')
                    ->method('saveSettings')
                    ->type(Color::PRIMARY)
                    ->rawClick(),
            ]),
            Switcher::make('api.wildberries.active')
                ->title('Включить передачу')
                ->checked(config('external-api.' . WbRepository::MARKETPLACE . '.active')),
        ];
    }

    public static function saveSettings(Request $request): void
    {
        $key = data_get($request, 'api.' . WbRepository::MARKETPLACE . '.key');
        $active = data_get($request, 'api.' . WbRepository::MARKETPLACE . '.active');
        WbRepository::setKey($key);

        saveToEnv('WB_API_KEY', $key);
        saveToEnv('WB_API_KEY_ACTIVE', is_null($active) ? 'false' : 'true');
        event(new UpdateWbRepositoryEvent($key));

        Toast::info('Настройки сохранены');
    }
}
