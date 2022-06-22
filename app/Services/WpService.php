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
    private array $fetchedSingleRecords = [];


    public function getSingleRecords(): array
    {
        if (empty($this->fetchedLists)) {
            $this->getLists();
        }

        foreach ($this->fetchedLists as $list => $data) {

            $listTitleSingular = Str::singular($list);

            $this->fetchedSingleRecords[$listTitleSingular] = array_map(function ($item) use ($listTitleSingular) {

                $itemArr = array_values((array)$item);
                return $this->get("{$listTitleSingular}/{$itemArr[0]}");

            }, json_decode($data));

        }

        return $this->fetchedSingleRecords;

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

        if (!$responseData) {
            return '';
        }

        try {
            $data = json_encode($responseData, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            // galima pranesti apie nesegminga bandyma dekoduoti JSON
            // tai gali reiksti kad WP servisas neveikia
            // galima uzloginti klaida su Log::error($e->getMessage());
            // galima siusti i koki nors servisa kuris klaidas gaudo, pvz Sentry
            return '';
        }

        return $data;
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
