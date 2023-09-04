<?php

namespace App\Console\Commands\Traits;

use App\ExternalApi\ExternalApiRepositoryInterfase;
use Exception;

trait HasMarketplace
{
    private ExternalApiRepositoryInterfase $repository;

    public function askMarketplaceName(): string|null
    {
        $marketplace = $this->option('marketplace');

        if (!$marketplace) {
            $marketplaces = config('external-api', []);
            $marketplace = $this->choice('Маркетплейс', array_keys($marketplaces));
        }

        $this->bootMarketplace($marketplace);

        return $marketplace;
    }

    private function bootMarketplace($marketplace): void
    {
        $config = config("external-api.$marketplace");

        if (!$config) {
            throw new Exception("Маркетплейс `$marketplace` не авторизован в системе");
        }

        $this->repository = new $config['repository']();
    }

    public function repository(): ExternalApiRepositoryInterfase
    {
        return $this->repository;
    }

}
