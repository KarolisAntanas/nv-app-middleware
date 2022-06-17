<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResourceIndexTrait
{
    public function index(): JsonResponse
    {
        if ($this->cacheService->exists($this->resource)) {
            return response()->json(
                $this->cacheService->get($this->resource),
            );
        }

        $resource = $this->wpService->get($this->resource);

        if ($resource) {
            $this->cacheService->set(
                $this->resource,
                $this->wpService->get($this->resource),
            );
        }

        return response()->json(
            $this->cacheService->get($this->resource),
        );
    }
}
