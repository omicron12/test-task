<div class="mb-3">

    <label class="form-label">
        {{__('Токен подключения к платформе')}}
    </label>

    {!!  \Orchid\Screen\Fields\Input::make('token')
        ->type('password')
        ->required()
        ->tabindex(1)
        ->autofocus()
        ->inputmode('text')
        ->placeholder('Токен клиента')
    !!}
</div>
