<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class ApiController extends Controller
{
    public array $routes = [];
    public array $objects = [];
    public array $routesIds = [];

    public function __construct()
    {
       $this->getAllRoutes();
        $this->getAllObjects();
        $this->extractRoutesIds();
    }

    public function getAllRoutes() {
        $routes = Http::get(config('api.api_url') . 'routes')->body();

        if($routes) {
            $this->routes = json_decode($routes);
            ray( $this->routes);
            Redis::set('routes', $routes);
        }
    }

    public function getAllObjects() {
        $objects = Http::get(config('api.api_url') . 'objects')->body();

        if($objects) {
            $this->objects = json_decode($objects);
            Redis::set('objects',  $objects);
        }
    }

    public function extractRoutesIds() {
        if(empty($this->routes)) {
            return;
        }

        $this->routesIds = array_map(function($route) {
            return $route->routeID;
        }, $this->routes);

    }


}
