<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CacheService;
use App\Services\WpService;
use App\Traits\ResourceIndexTrait;
use App\Traits\ResourceShowTrait;
use Illuminate\Http\JsonResponse;

class ObjectController extends Controller
{
    use ResourceIndexTrait;
    use ResourceShowTrait;


    protected string $resource = 'objects';
    protected string $resourceSingular = 'object';


    public function __construct(
        private CacheService $cacheService,
        private WpService    $wpService,
    )
    {
        if(request()->version) {
            $this->resource = request()->version . "/" . $this->resource;
        } else {
            $this->resource = "v2/" . $this->resource;
        }
    }
}
