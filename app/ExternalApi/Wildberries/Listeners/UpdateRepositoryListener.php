<?php

namespace App\ExternalApi\Wildberries\Listeners;

use App\ExternalApi\Wildberries\Events\UpdateWbRepositoryEvent;
use App\ExternalApi\Wildberries\Repositories\WbRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateRepositoryListener implements ShouldQueue
{
    public function __construct(public WbRepository $apiRepository)
    {

    }

    public function handle(UpdateWbRepositoryEvent $event)
    {
        $this->apiRepository->setKey($event->apiKey);

        $this->apiRepository->truncate();
        $this->apiRepository->sales([
            'dateFrom' => now()->subWeekdays(2)->format('Y-m-d')
        ]);
    }
}
