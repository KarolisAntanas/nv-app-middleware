<?php

namespace App\Console\Commands;

use App\Services\DataFetchService;
use Illuminate\Console\Command;

class FetchData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches data from WP to cache';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        new DataFetchService();
    }
}
