<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class ApiController extends Controller
{
    public function index() {
        Redis::set('route', json_encode([
            'routeID' => 19152,
            'routeTitle' => 'Kelionė laiku 2-uoju troleibusu',
        ]));

        return Redis::get('route');

    }
}
