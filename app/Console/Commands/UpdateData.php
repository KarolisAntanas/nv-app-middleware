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


        $this->updateLists('v2');
        $this->updateLists('v3');
        $this->updateSingleRecords('v2');
        $this->updateSingleRecords('v3');


        $this->updateCategories('v2');
        $this->updateCategories('v3');

        $this->updatePages('v2');
        $this->updatePages('v3');


        $this->newLine();
        $this->info("Data update finished");

    }

    private function updateLists($version): void
    {

        $this->info("fetching lists");

        $lists = $this->wpService->getLists($version);

        foreach ($lists as $list => $data) {

            $this->newLine();
            $this->info($this->cacheService->set($version . '/' . $list, $data));

        }

    }

    private function updateSingleRecords($version): void
    {

        $this->newLine();
        $this->info("fetching single records");

        $singleRecordsIDs = $this->wpService->getSingleRecordsIDs();

        foreach ($singleRecordsIDs as $type => $IDs) {

            foreach ($IDs as $ID) {

                $record = $this->wpService->get("${version}/{$type}/{$ID}");

                $this->newLine();
                $this->info($this->cacheService->set("${version}/{$type}:{$ID}", $record));


            }

        }

    }

    private
    function updateCategories($version): void
    {
        $this->newLine();
        $this->info("fetching categories");

        $categories = $this->wpService->getCategories($version);

        foreach ($categories as $category => $data) {

            $this->newLine();
            $this->info($this->cacheService->set($version . '/' . $category, $data));

        }

    }

    private
    function updatePages($version): void
    {
        $this->newLine();
        $this->info("fetching pages");

        $pages = $this->wpService->getPages($version);

        foreach ($pages as $page => $data) {

            $this->newLine();
            $this->info($this->cacheService->set($version . '/' . $page, $data));

        }

    }


}
