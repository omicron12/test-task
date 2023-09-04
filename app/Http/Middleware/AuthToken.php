<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (!$this->isValidToken($token)) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        return $next($request);
    }

    private function isValidToken($token): bool
    {
        $clientToken = config('client.token');
        return $clientToken === $token;
    }
}
