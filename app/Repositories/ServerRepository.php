<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class ServerRepository
{
    public static function updateClientCredentials($token)
    {
        $response = Http::withHeader('Authorization', $token)
            ->baseUrl(config('server.api.url'))
            ->get('/bb/credentials');

        if ($response->ok()) {
            $bucket = $response->json('bucket');

            saveToEnv('S3_PUBLIC_BUCKET', $bucket['name']);
            saveToEnv('S3_ACCESS_KEY_ID', $bucket['key_id']);
            saveToEnv('S3_SECRET_ACCESS_KEY', $bucket['access_key']);
        } else {
            abort(401);
        }


        return $response->json();
    }

}
