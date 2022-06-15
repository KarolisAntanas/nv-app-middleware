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

        $routes = $this->wpService->get($this->resource);

        if ($routes) {
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
