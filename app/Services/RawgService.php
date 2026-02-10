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
            'page_size' => 40,
        ])->json();
    }

    public function game(int $id)
    {
        return Http::get("{$this->baseUrl}/games/{$id}", [
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
