<?php

namespace App\Orchid\Screens\Marketplace\Wildberries\Layouts;

use App\Orchid\Screens\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Layouts\Rows;

class MassActionsLayout extends Rows
{

    protected function fields(): iterable
    {
        $total = SalesTableLayout::query()->get()->count();

        return [
            DropDown::make("Массовые действия ($total)")
                ->icon('bs.card-checklist')
                ->list([
                    Button::make('Включить все')
                        ->icon('icon-wallet')
                        ->method('addSelected'),
                    Button::make('Выключить все')
                        ->icon('icon-wallet')
                        ->method('removeSelected'),
                ]),
        ];
    }

}
