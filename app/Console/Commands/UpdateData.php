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

    }

    private function updateLists(): void
    {

        $this->info("fetching lists");

        $lists = $this->wpService->getLists();

        foreach ($lists as $list => $data) {

            $this->newLine();
            $this->info("saving {$list}");

            $this->cacheService->set($list, $data);
        }

    }

    private function updateSingleRecords(): void
    {

        $this->newLine();
        $this->info("fetching single records");

        $singleRecords = $this->wpService->getSingleRecords();

        foreach ($singleRecords as $type => $data) {

            foreach ($data as $record) {

                $record = (array)json_decode($record);
                $recordID = array_values($record)[0] ?? null;

                if (empty($recordID)) {
                    return;
                }

                $this->newLine();
                $this->info("saving {$type} record with id of {$recordID}");

                $this->cacheService->set("{$type}:{$recordID}", json_encode($record));

            }


        }

    }

    private function updateCategories(): void
    {
        $this->newLine();
        $this->info("fetching categories");

        $categories = $this->wpService->getCategories();

        foreach ($categories as $category => $data) {

            $this->newLine();
            $this->info("saving {$category}");

            $this->cacheService->set($category, $data);
        }

    }

    private function updatePages(): void
    {
        $this->newLine();
        $this->info("fetching pages");

        $pages = $this->wpService->getPages();

        foreach ($pages as $page => $data) {

            $this->newLine();
            $this->info("saving {$page}");

            $this->cacheService->set($page, $data);
        }

    }


}
