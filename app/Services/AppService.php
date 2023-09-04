<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\ServerRepository;
use Illuminate\Support\Facades\Artisan;
use Orchid\Support\Facades\Dashboard;

class AppService
{
    public function init(array $config)
    {
        $this
            ->updateClientToken($config['token'])
            ->createAdmin($config['email'], $config['password']);
    }

    public function createAdmin(string $login, string $password): static
    {
        $user = User::firstWhere('email', $login);

        if (!$user) {
            Dashboard::modelClass(\Orchid\Platform\Models\User::class)
                ->createAdmin(
                    'admin',
                    $login,
                    $password
                );
        }

        return $this;
    }

    public function updateClientToken($token): static
    {
        saveToEnv('CLIENT_TOKEN', $token);
        ServerRepository::updateClientCredentials($token);

        return $this;
    }

    public function createDb(): static
    {
        $filePath = base_path('/database.sqlite');

        if (!file_exists($filePath)) {
            file_put_contents($filePath, '');
        }

        Artisan::call('migrate');

        return $this;
    }

}
