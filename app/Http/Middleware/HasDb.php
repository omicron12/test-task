<?php

namespace App\Http\Middleware;

use App\Facades\AppService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class HasDb
{

    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!Schema::hasTable('user')) {
                AppService::createDb();
            }
        } catch (\Exception $e) {
            AppService::createDb();
        }

        return $next($request);
    }
}
