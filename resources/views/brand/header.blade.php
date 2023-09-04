@push('head')
    <link
        href="/favicon.ico"
        id="favicon"
        rel="icon"
    >
@endpush

<p class="h2 n-m font-thin v-center">
    <x-orchid-icon path="database"/>
    <span class="m-l d-none d-sm-block">
        Analytics
        <small class="v-top opacity">{{config('app.name')}}</small>
    </span>
</p>
