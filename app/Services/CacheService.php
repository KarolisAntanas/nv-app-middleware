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

        return json_decode($cacheData, true);
    }


    public function set(string $key, string $value): string
    {
        if ($value) {
            Redis::set($key, $value);
            return "{$key} saved successfully";
        }

        return "unexpected {$key} data - not saved";

    }

    public function exists(string $key): bool
    {
        return (bool)Redis::exists($key);
    }
}
