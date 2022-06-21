<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\WpService;
use App\Services\CacheService;


class DataFetchService
{

    private array $lists = ['pois', 'routes', 'objects'];
    private array $fetchedLists = [];

    public function __construct()
    {
        $this->wpService = new WpService();
        $this->cacheService = new CacheService();

        $this->fetchLists();
        $this->saveLists();
        $this->fetchSingleRecords();

    }


    public function fetchLists(): void
    {

        if (empty($this->lists)) {
            return;
        }

        foreach ($this->lists as $list) {
            $fetchedListData = $this->wpService->get($list);

            $this->fetchedLists[$list]['data'] = $fetchedListData;
            $this->fetchedLists[$list]['IDs'] = $this->extractListIDs($fetchedListData);

        }

    }

    public function extractListIDs(string $list): array
    {
        return array_map(function ($item) {

            $itemArr = (array)$item;
            return array_values($itemArr)[0] ?? null;

        }, json_decode($list));
    }

    public function saveLists(): void
    {
        if (empty($this->fetchedLists)) {
            return;
        }

        foreach ($this->fetchedLists as $listTitle => $list) {
            $this->cacheService->set($listTitle, $list['data']);
        }

    }

    public function fetchSingleRecords(): void
    {
        if (empty($this->fetchedLists)) {
            return;
        }

        foreach ($this->fetchedLists as $listTitle => $list) {

            if (empty($list['IDs'])) {
                continue;
            }

            foreach ($list['IDs'] as $ID) {

                $listTitleSingular = substr($listTitle, 0, -1);

                $record = $this->wpService->get("{$listTitleSingular}/{$ID}");
                $this->cacheService->set("{$listTitleSingular}:{$ID}", $record);

            }


        }

    }

}
