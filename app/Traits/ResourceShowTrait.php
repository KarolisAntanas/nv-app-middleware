<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResourceShowTrait
{
    public function show(string $singleResourceId): JsonResponse
    {
        $cacheKey = "{$this->resourceSingular}:{$singleResourceId}";

        if ($this->cacheService->exists($cacheKey)) {
            return response()->json(
                $this->cacheService->get($cacheKey),
            );
        }

        $resource = $this->wpService->get("{$this->resourceSingular}/{$singleResourceId}");

        if (empty($resource)) {
            return response()->json('No data available');
        }

        $this->cacheService->set($cacheKey, $resource);

        return response()->json($this->cacheService->get($cacheKey));

    }
}
