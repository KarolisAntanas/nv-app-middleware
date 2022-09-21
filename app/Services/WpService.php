<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use JsonException;

class WpService
{

    private array $lists = ['pois', 'routes', 'objects'];
    private array $categories = ['front-poi-categories', 'route-categories', 'poi-categories'];
    private array $pages = ['about', 'text-pages', 'contacts', 'misc-info', 'last-modified'];
    private array $fetchedLists = [];
    private array $fetchedCategories = [];
    private array $fetchedPages = [];
    private array $singleRecordsIDs = [];


    public function getSingleRecordsIDs(): array
    {
        if (empty($this->fetchedLists)) {
            $this->getLists();
        }

        foreach ($this->fetchedLists as $list => $data) {

            if(!$decodedData = json_decode($data)) {
                continue;
            }

            $listTitleSingular = Str::singular($list);

            $this->singleRecordsIDs[$listTitleSingular] = array_map(function ($item) use ($listTitleSingular) {

                $itemArr = array_values((array)$item);
                return $itemArr[0] ?? null;

            }, $decodedData);

        }

        return $this->singleRecordsIDs;

    }

    public function getLists(): array
    {
        if (empty($this->lists)) {
            return [];
        }

        foreach ($this->lists as $list) {

            $fetchedListData = $this->get($list);
            $this->fetchedLists[$list] = $fetchedListData;

        }

        return $this->fetchedLists;

    }

    public function get(string $resource): string
    {
        $responseData = Http::acceptJson()
            ->get(config('api.api_url') . $resource)
            ->json();

        if (!$this->isValid($responseData)) {
            return '';
        }

        return json_encode($responseData);
    }

    private function isValid($data): bool
    {

        if (!is_array($data)) {
            return false;
        }

        if (empty($data)) {
            return false;
        }

        if (!empty($data['code'])) {
            return false;
        }

        return true;
    }

    public function getCategories(): array
    {
        if (empty($this->categories)) {
            return [];
        }

        foreach ($this->categories as $category) {

            $fetchedCategoryData = $this->get($category);
            $this->fetchedCategories[$category] = $fetchedCategoryData;

        }

        return $this->fetchedCategories;
    }

    public function getPages(): array
    {
        if (empty($this->pages)) {
            return [];
        }

        foreach ($this->pages as $page) {

            $fetchedPageData = $this->get($page);
            $this->fetchedPages[$page] = $fetchedPageData;

        }

        return $this->fetchedPages;
    }

}
