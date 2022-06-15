<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use JsonException;

class CacheService
{
    public function get(string $key): array
    {
        $cacheData = Redis::get($key);

        if (!$cacheData) {
            return [];
        }

        try {
            $data = json_decode($cacheData, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            // galima pranesti apie nesegminga bandyma dekoduoti JSON
            // tai gali reiksti kad cache duomenys yra neteisingi
            // galima uzloginti klaida su Log::error($e->getMessage());
            // galima siusti i koki nors servisa kuris klaidas gaudo, pvz Sentry
            return [];
        }

        return $data;
    }

    public function set(string $key, string $value): void
    {
        Redis::set($key, $value);
    }

    public function exists(string $key): bool
    {
        return (bool) Redis::exists($key);
    }
}
