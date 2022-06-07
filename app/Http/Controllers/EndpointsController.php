<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;


class EndpointsController extends Controller
{

    public function api() {
        new ApiController();
    }

    public function routes() {
        return Redis::get('routes');
    }

    public function objects() {
        return Redis::get('objects');
    }

}

