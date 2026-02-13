<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RawgService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.rawg.url');
        $this->apiKey = config('services.rawg.key');
    }

    public function games(int $page = 1)
    {
        return Http::get("{$this->baseUrl}/games", [
            'key' => $this->apiKey,
            'page' => $page,
            'page_size' => 100,
        ])->json();
    }

    public function gameInfo(int $id)
    {
        return Http::get("{$this->baseUrl}/games/{$id}", [
            'key' => $this->apiKey,
        ])->json();
    }

    public function gameStoresUrl(int $id)
    {
        return Http::get("{$this->baseUrl}/games/{$id}/stores", [
            'key' => $this->apiKey,
        ])->json();
    }

    public function gameTrailer(int $id)
    {
        return Http::get("{$this->baseUrl}/games/{$id}/movies", [
            'key' => $this->apiKey,
        ])->json();
    }

    public function genres()
    {
        return Http::get("{$this->baseUrl}/genres", [
            'key' => $this->apiKey,
            'page_size' => 40,
        ])->json();
    }

    public function platforms()
    {
        return Http::get("{$this->baseUrl}/platforms", [
            'key' => $this->apiKey,
            'page_size' => 40,
        ])->json();
    }
}
