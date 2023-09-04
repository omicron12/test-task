<?php

namespace App\ExternalApi;

interface ExternalApiRepositoryInterfase
{
    public static function getKey(): ?string;

    public static function setKey($key): void;

    public static function getKeyHash(): string;

    public static function getMarketplaceName(): string;
}
