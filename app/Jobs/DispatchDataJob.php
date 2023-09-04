<?php

namespace App\Jobs;

use App\Export\CsvWriter;
use App\ExternalApi\ExternalApiRepositoryInterfase;
use App\Models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DispatchDataJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private string $filePath;
    private mixed $csvGenerator;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly string                         $date,
                                public readonly ExternalApiRepositoryInterfase $repository)
    {
        $this->filePath = storage_path("app/csv/$date.csv");
        $this->csvGenerator = new CsvWriter();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sales = Sale::whereDate('date', $this->date)
            ->withKey($this->repository::getKeyHash())
            ->active()
            ->get();

        $marketplace = $this->repository::getMarketplaceName();

        $this->csvGenerator->make($sales, $this->filePath);
        $storagePath = $this->putToStorage($this->date, $marketplace);

        Log::info(__METHOD__, [
            "Данные маркетплейса `$marketplace` отправлены" => [
                'date' => $this->date,
                'storage path' => $storagePath,
                'rows' => $sales->count(),
            ]
        ]);

    }

    private function putToStorage(string $date, string $marketplace): string
    {
        $storagePath = "$marketplace/sales/$date.csv";

        Storage::disk('s3')->put($storagePath, file_get_contents($this->filePath));
        unlink($this->filePath);

        return $storagePath;
    }
}
