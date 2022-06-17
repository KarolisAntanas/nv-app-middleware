<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use JsonException;

class WpService
{
    public function get(string $resource): string
    {
        $responseData = Http::acceptJson()
            ->get(config('api.api_url') . $resource)
            ->json();

        if (!$responseData) {
            return '';
        }

        try {
            $data = json_encode($responseData, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            // galima pranesti apie nesegminga bandyma dekoduoti JSON
            // tai gali reiksti kad WP servisas neveikia
            // galima uzloginti klaida su Log::error($e->getMessage());
            // galima siusti i koki nors servisa kuris klaidas gaudo, pvz Sentry
            return '';
        }

        return $data;
    }
}
