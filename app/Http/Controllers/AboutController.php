<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CacheService;
use App\Services\WpService;
use App\Traits\ResourceIndexTrait;

class AboutController extends Controller
{
    use ResourceIndexTrait;

    protected string $resource = 'about';


    public function __construct(
        private CacheService $cacheService,
        private WpService    $wpService,
    )
    {
    }

}

