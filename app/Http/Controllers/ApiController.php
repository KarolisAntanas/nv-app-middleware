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
        $this->getFullRouteData();

    }

    public function getAllRoutes() {
        $routes = Http::get(config('api.api_url') . 'routes');

        if($routes->body()) {
            $this->routes = json_decode($routes->body());
            Redis::set('routes', $routes->body());
        }
    }

    public function getAllObjects() {
        $objects = Http::get(config('api.api_url') . 'objects');

        if($objects->body()) {
            $this->objects = json_decode($objects->body());
            Redis::set('objects',  $objects->body());
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

    public function getFullRouteData() {
        if(empty($this->routesIds)) {
            return;
        }

        foreach($this->routesIds as $id) {
            $route = Http::get(config('api.api_url') . 'route/' . $id);

            $route = $route->body() ?? null;

            if($route) {
                Redis::set('route:' . $id, $route);
            }

        }

    }



}
