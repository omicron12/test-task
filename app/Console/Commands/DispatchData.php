<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\HasDate;
use App\Console\Commands\Traits\HasMarketplace;
use App\Jobs\DispatchDataJob;
use Illuminate\Console\Command;

class DispatchData extends Command
{
    use HasMarketplace;
    use HasDate;

    protected $signature = 'app:dispatch-data
    {--m|marketplace= : Название маркетплейса в системе}
    {--d|fromDate= : Дата обновления информации в сервисе}';

    protected $description = 'Отправка данных в хранилище';

    public function handle(): void
    {
        $this->askMarketplaceName();

        dispatch(new DispatchDataJob($this->getDate(), $this->repository()));
    }
}
