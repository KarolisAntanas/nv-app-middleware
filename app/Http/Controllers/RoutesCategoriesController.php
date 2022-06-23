<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CacheService;
use App\Services\WpService;
use App\Traits\ResourceIndexTrait;
use Illuminate\Http\JsonResponse;

class RoutesCategoriesController extends Controller
{
    use ResourceIndexTrait;

    protected string $resource = 'route-categories';


    public function __construct(
        private CacheService $cacheService,
        private WpService    $wpService,
    )
    {
    }

}

