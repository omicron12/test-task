<?php

namespace App\Console;

use App\ExternalApi\Wildberries\Repositories\WbRepository;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $fromDate = now()->subDays(2)->format('Y-m-d');
        $wb = WbRepository::MARKETPLACE;

        if ($this->marketplaceIsActive(WbRepository::MARKETPLACE)) {
            $schedule->command("app:api-get -m $wb -d $fromDate")->dailyAt('00:30');
            $schedule->command("app:dispatch-data -m $wb -d $fromDate")->dailyAt('01:00');
        }

    }

    public function marketplaceIsActive(string $marketplace)
    {
        return config("external-api.$marketplace.active");
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
