<?php

namespace App\Console\Commands\Traits;

use Carbon\Carbon;

trait HasDate
{
    public function getDate(): string|null
    {
        $dateFrom = $this->option('fromDate');
        $dateFrom = $dateFrom
            ? Carbon::parse($dateFrom)
            : now();

        return $dateFrom->format('Y-m-d');
    }

}
