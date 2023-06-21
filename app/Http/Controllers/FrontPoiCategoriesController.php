<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CacheService;
use App\Services\WpService;
use App\Traits\ResourceIndexTrait;
use Illuminate\Http\JsonResponse;

class FrontPoiCategoriesController extends Controller
{
    use ResourceIndexTrait;

    protected string $resource = 'front-poi-categories';


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

