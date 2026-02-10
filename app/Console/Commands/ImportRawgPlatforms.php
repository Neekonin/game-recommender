<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RawgService;
use App\Models\Platform;

class ImportRawgPlatforms extends Command
{
    protected $signature = 'rawg:import-platforms';
    protected $description = 'Import platforms from RAWG';

    public function handle(RawgService $rawg)
    {
        $response = $rawg->platforms();

        foreach ($response['results'] as $item) {
            Platform::updateOrCreate(
                ['rawg_id' => $item['id']],
                [
                    'name' => $item['name'],
                    'slug' => $item['slug'],
                ]
            );
        }

        $this->info('Platforms importadas com sucesso.');
        return Command::SUCCESS;
    }
}
