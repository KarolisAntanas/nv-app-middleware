<?php

namespace App\Console\Commands;

//use App\Services\DataUpdateService;
use Illuminate\Console\Command;
use App\Services\WpService;
use App\Services\CacheService;


class UpdateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches data from WP and saves it to cache';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {

        $this->wpService = new WpService();
        $this->cacheService = new CacheService();


        $this->info("Data update started");
        $this->newLine();


        $this->updateLists();
        $this->updateSingleRecords();

        $this->updateCategories();
        $this->updatePages();

        $this->newLine();
        $this->info("Data update finished");

    }

    private function updateLists(): void
    {

        $this->info("fetching lists");

        $lists = $this->wpService->getLists();

        foreach ($lists as $list => $data) {

            $this->newLine();
            $this->info($this->cacheService->set($list, $data));

        }

    }

    private function updateSingleRecords(): void
    {

        $this->newLine();
        $this->info("fetching single records");

        $singleRecordsIDs = $this->wpService->getSingleRecordsIDs();

        foreach ($singleRecordsIDs as $type => $IDs) {

            foreach ($IDs as $ID) {

                $record = $this->wpService->get("{$type}/{$ID}");

                $this->newLine();
                $this->info($this->cacheService->set("{$type}:{$ID}", $record));


            }

        }

    }

    private
    function updateCategories(): void
    {
        $this->newLine();
        $this->info("fetching categories");

        $categories = $this->wpService->getCategories();

        foreach ($categories as $category => $data) {

            $this->newLine();
            $this->info($this->cacheService->set($category, $data));

        }

    }

    private
    function updatePages(): void
    {
        $this->newLine();
        $this->info("fetching pages");

        $pages = $this->wpService->getPages();

        foreach ($pages as $page => $data) {

            $this->newLine();
            $this->info($this->cacheService->set($page, $data));

        }

    }


}
