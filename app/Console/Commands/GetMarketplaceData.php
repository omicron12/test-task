<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\HasDate;
use App\Console\Commands\Traits\HasMarketplace;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GetMarketplaceData extends Command
{
    use HasMarketplace;
    use HasDate;

    protected $signature = 'app:api-get
    {--m|marketplace= : Название маркетплейса в системе}
    {--d|fromDate= : Дата обновления информации в сервисе}';

    protected $description = 'Получить данные маркетплейса';

    public function handle(): void
    {
        $dateFrom = $this->getDate();
        $marketplace = $this->askMarketplaceName();
        $this->repository()->sales(['dateFrom' => $dateFrom]);

        Log::info(__METHOD__, [
            "Данные маркетплейса `$marketplace` получены" => [
                'dateFrom' => $dateFrom,
            ]
        ]);
    }
}
