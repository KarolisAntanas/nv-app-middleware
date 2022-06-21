<?php

namespace App\Http\Controllers;

use App\Console\Commands\FetchData;
use App\Services\DataFetchService;

class FetchController extends Controller
{
    public function index(): void
    {
        (new FetchData())->handle();
    }
}
