<?php

namespace App\ExternalApi\Wildberries\Repositories;

use App\ExternalApi\ExternalApiRepositoryInterfase;
use App\ExternalApi\Wildberries\Dto\WbSaleDto;
use App\Models\Sale;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * Class WbRepository.
 *
 * @method WbRepository sales(array $params)
 */
class WbRepository implements ExternalApiRepositoryInterfase
{
    const MARKETPLACE = 'wildberries';

    private static PendingRequest $client;

    private array $allowedMethods = [
        'sales',
    ];

    public function __construct()
    {
        self::initClient();
    }

    public static function initClient(): void
    {
        $baseUrl = config('external-api.wildberries.url');
        $authorizationKey = self::getKey();

        self::$client = Http::baseUrl($baseUrl)
            ->withHeaders([
                    'Authorization' => $authorizationKey,
                ]
            );
    }

    public static function getKey(): ?string
    {
        return config('external-api.wildberries.key');
    }

    public static function setKey($key): void
    {
        config(['external-api.wildberries.key' => $key]);
        self::initClient();
    }

    public static function getKeyHash(): string
    {
        return sha1(self::getKey());
    }

    public static function getMarketplaceName(): string
    {
        return self::MARKETPLACE;
    }

    public function __call(string $name, array $arguments): mixed
    {
        if (!in_array($name, $this->allowedMethods)) {
            throw new BadRequestException();
        }

        $response = self::$client->get($name, $arguments[0]);
        $data = $response->json();

        if (!$response->ok()) {
            Log::debug(__METHOD__, [
                'api method' => $name,
                data_get($data, 'error', $response->body())
            ]);

            return false;
        }

        $method = 'handling' . Str::ucfirst($name);

        if (method_exists(self::class, $method)) {
            return $this->$method($data);
        }

        return $data;
    }

    private function handlingSales($data): void
    {
        foreach ($data as $item) {

            if (!str_starts_with($item['saleID'], 'S')) {
                continue;
            }

            $sale = (new WbSaleDto($item))->toArray();

            Sale::updateOrCreate([
                'hash' => $sale['hash']
            ], $sale);
        }
    }

    public function truncate(): void
    {
        Sale::where('source', self::class)->delete();
    }
}
