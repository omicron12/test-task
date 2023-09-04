<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/login', function () {
    return redirect('/admin/login');
});

if (config('platform.auth', true)) {

    Route::middleware('throttle:60,1')
        ->post('login', [LoginController::class, 'login'])
        ->name('app.login.auth');

    Route::get('sales/download', [SalesController::class, 'download'])
        ->name('sales.download');
}
