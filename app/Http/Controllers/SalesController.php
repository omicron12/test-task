<?php

namespace App\Http\Controllers;

use App\Export\CsvWriter;
use App\Jobs\UnlinkFileJob;
use App\Models\Sale;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SalesController extends Controller
{
    public function download(Request $request, CsvWriter $writer): BinaryFileResponse
    {
        $date = $request->get('date');
        $marketplace = $request->get('marketplace');
        $repository = config("external-api.$marketplace.repository");
        $fileName = 'sales';

        if (!$repository) {
            abort(404);
        }

        $query = Sale::withKey($repository::getKeyHash())->active();

        if ($date) {
            $query->whereDate('date', $date);
            $fileName = "sales-$date";
        }

        $filePath = storage_path("app/csv/$fileName.csv");

        $models = $query->get();
        $writer->make($models, $filePath);

        if (config('queue.default') !== 'sync') {
            dispatch(new UnlinkFileJob($filePath))
                ->delay(now()->addMinutes(15));
        }

        return response()->download($filePath);
    }

}
