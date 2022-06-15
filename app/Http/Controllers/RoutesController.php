<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CacheService;
use App\Services\WpService;
use App\Traits\ResourceIndexTrait;
use Illuminate\Http\JsonResponse;

class RoutesController extends Controller
{
    use ResourceIndexTrait;

    protected string $resource = 'routes';

    public function __construct(
        private CacheService $cacheService,
        private WpService $wpService,
    ) {}

    public function route(string $routeId): JsonResponse
    {
        return response()->json(
            $this->cacheService->get('route:' . $routeId)
        );
    }
}

