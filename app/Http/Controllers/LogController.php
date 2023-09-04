<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LogController extends Controller
{
    public function show(string $date): BinaryFileResponse|JsonResponse
    {
        $fileName = "laravel-$date.log";
        $path = Storage::disk('logs')->path($fileName);

        if (Storage::disk('logs')->exists($fileName)) {
            return response()->file($path);
        }

        return response()->json(['error' => 'Log file not found'], 404);
    }
}
