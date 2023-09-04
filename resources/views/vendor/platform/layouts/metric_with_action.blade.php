<div class="mb-3">
    @isset($title)
        <legend class="text-black px-4 mb-0">
            {{ __($title) }}
        </legend>
    @endisset
    <div class="row mb-2 g-3 g-mb-4">
        <div class="col">
            <div class="p-4 bg-white rounded shadow-sm h-100 d-flex flex-column align-items-start">
                <small class="text-muted d-block mb-1">{{ __($name ?? '') }}</small>
                <p class="h3 text-black fw-light mt-auto">
                    {{ data_get(${$key}, $value) }}
                </p>
                @include("platform::layouts.actions.$action[name]")
            </div>
        </div>
    </div>
</div>
