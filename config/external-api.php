<?php

return [
    'wildberries' => [
        'key' => env('WB_API_KEY'),
        'active' => env('WB_API_KEY_ACTIVE'),
        'url' => env('WB_API_URL'),
        'repository' => \App\ExternalApi\Wildberries\Repositories\WbRepository::class
    ]
];
