<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CacheService;
use App\Services\WpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;

class EndpointsController extends Controller
{
    public function __construct(
        private CacheService $cacheService,
        private WpService $wpService,
    ) {}

    public function routes(): JsonResponse
    {
        if ($this->cacheService->exists('routes')) {
            return response()->json(
                $this->cacheService->get('routes'),
            );
        }

        $this->cacheService->set(
            'routes',
            $this->wpService->getRoutes(),
        );

        return response()->json(
            $this->cacheService->get('routes'),
        );
    }

    public function route($request) {
        return json_decode(Redis::get('route:' . $request));
    }

    public function objects() {
        return json_decode(Redis::get('objects'));
    }

}

