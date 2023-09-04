<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

if (!function_exists('saveToEnv')) {
    function saveToEnv(string $param, ?string $value): void
    {
        $newSettings = "$param=\"$value\"";

        $envFilePath = base_path('.env');

        if (File::exists($envFilePath)) {
            $currentSettings = File::get($envFilePath);

            $updatedSettings = preg_replace("/^$param=.*/m", $newSettings, $currentSettings);

            File::put($envFilePath, $updatedSettings);
        }

        Artisan::call('config:clear');
    }
}
