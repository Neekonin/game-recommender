<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Services\RawgService;
use App\Models\{
    Game,
    Genre,
    Platform,
    Style,
    Store,
    GameScreenshot
};

class ImportRawgGames extends Command
{
    protected $signature = 'rawg:import-games {--pages=1}';
    protected $description = 'Import games with genres, platforms, tags, stores and screenshots from RAWG';

    public function handle(RawgService $rawg)
    {
        $pages = (int) $this->option('pages');

        for ($page = 1; $page <= $pages; $page++) {
            $this->info("📦 Importando página {$page}");

            $response = $rawg->games($page);

            foreach ($response['results'] as $item) {

                /* 🎮 GAME */
                $game = Game::updateOrCreate(
                    ['rawg_id' => $item['id']],
                    [
                        'name'         => $item['name'],
                        'slug'         => $item['slug'],
                        'released_at'  => $item['released'] ?? null,
                        'rating'       => $item['rating'] ?? null,
                        'metacritic'   => $item['metacritic'] ?? null,
                        'cover_image'  => $item['background_image'] ?? null,
                    ]
                );

                /* 🏷️ GENRES */
                if (!empty($item['genres'])) {
                    $genreIds = [];

                    foreach ($item['genres'] as $genre) {
                        $g = Genre::firstOrCreate(
                            ['rawg_id' => $genre['id']],
                            [
                                'name' => $genre['name'],
                                'slug' => $genre['slug'],
                            ]
                        );
                        $genreIds[] = $g->id;
                    }

                    $game->genres()->sync($genreIds);
                }

                /* 🕹️ PLATFORMS */
                if (!empty($item['platforms'])) {
                    $platformIds = [];

                    foreach ($item['platforms'] as $platformItem) {
                        $platform = $platformItem['platform'];

                        $p = Platform::firstOrCreate(
                            ['rawg_id' => $platform['id']],
                            [
                                'name' => $platform['name'],
                                'slug' => $platform['slug'],
                            ]
                        );
                        $platformIds[] = $p->id;
                    }

                    $game->platforms()->sync($platformIds);
                }

                /* 🧠 TAGS → GAME STYLES */
                if (!empty($item['tags'])) {
                    $genreSlugs = Genre::pluck('slug')->map(fn ($s) => strtolower($s));

                    foreach ($item['tags'] as $tag) {
                        if ($genreSlugs->contains(strtolower($tag['slug']))) {
                            continue;
                        }

                        Style::firstOrCreate(
                            ['rawg_id' => $tag['id']],
                            [
                                'name' => $tag['name'],
                                'slug' => $tag['slug'],
                            ]
                        );
                    }
                }

                /* 🏪 STORES */
                if (!empty($item['stores'])) {
                    $storeIds = [];

                    foreach ($item['stores'] as $storeItem) {
                        $store = $storeItem['store'];

                        $s = Store::firstOrCreate(
                            ['rawg_id' => $store['id']],
                            [
                                'name' => $store['name'],
                                'slug' => $store['slug'],
                            ]
                        );
                        $storeIds[] = $s->id;
                    }

                    $game->stores()->sync($storeIds);
                }

                /* 🖼️ SCREENSHOTS */
                if (!empty($item['results']['screenshots'])) {
                    foreach ($item['results'] as $screenshots) {
                        GameScreenshot::firstOrCreate(
                            [
                                'game_id' => $game->id,
                                'image'   => $screenshots['image'],
                            ]
                        );
                    }
                }
            }
        }

        $this->info('✅ Importação concluída com sucesso');
        return Command::SUCCESS;
    }
}
