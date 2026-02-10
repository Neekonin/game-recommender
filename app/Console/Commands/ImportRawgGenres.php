<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RawgService;
use App\Models\Genre;

class ImportRawgGenres extends Command
{
    protected $signature = 'rawg:import-genres';
    protected $description = 'Import genres from RAWG';

    public function handle(RawgService $rawg)
    {
        $response = $rawg->genres();

        foreach ($response['results'] as $item) {
            Genre::updateOrCreate(
                ['rawg_id' => $item['id']],
                [
                    'name' => $item['name'],
                    'slug' => $item['slug'],
                ]
            );
        }

        $this->info('Genres importados com sucesso.');
        return Command::SUCCESS;
    }
}
