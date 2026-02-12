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
    Screenshot
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
                /* JOGOS */
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

                /* GÊNEROS */
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

                /* PLATAFORMAS */
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

                /* ESTILOS */
                if (!empty($item['tags'])) {
                    $stylesIds = [];
                    $genreSlugs = Genre::pluck('slug')->map(fn ($s) => strtolower($s));

                    foreach ($item['tags'] as $tag) {
                        if ($genreSlugs->contains(strtolower($tag['slug']))) {
                            continue;
                        }

                        $s = Style::firstOrCreate(
                            ['rawg_id' => $tag['id']],
                            [
                                'name' => $tag['name'],
                                'slug' => $tag['slug'],
                            ]
                        );
                        $stylesIds[] = $s->id;
                    }

                    $game->styles()->sync($stylesIds);
                }

                /* IMAGENS */
                if (!empty($item['short_screenshots'])) {
                    foreach ($item['short_screenshots'] as $key => $screenshots) {
                        if ($key == 0) {
                            continue;
                        }

                        $game->screenshots()->updateOrCreate(
                            [
                                'image' => $screenshots['image']
                            ],
                            []
                        );
                    }
                }

                $rawGameInfo = $rawg->gameInfo($item['id']);

                if (!empty($rawGameInfo['description_raw'])) {
                    $game->update([
                        'description' => $rawGameInfo['description_raw']
                    ]);
                }

                /* LOJAS */
                $rawGameStores = $rawg->gameStoresUrl($item['id']);

                if (!empty($rawGameStores['results'])) {
                    $syncData = [];

                    $urlMap = [];
                    foreach ($rawGameStores['results'] as $storeResult) {
                        $urlMap[$storeResult['store_id']] = $storeResult['url'];
                    }

                    foreach ($item['stores'] as $storeItem) {
                        $storeData = $storeItem['store'];

                        $store = Store::firstOrCreate(
                            ['rawg_id' => $storeData['id']],
                            [
                                'name' => $storeData['name'],
                                'slug' => $storeData['slug'],
                            ]
                        );

                        $storeUrl = $urlMap[$storeData['id']] ?? null;

                        $syncData[$store->id] = [
                            'url_store' => $storeUrl
                        ];
                    }

                    $game->stores()->sync($syncData);
                }

                /* TRAILERS */
                $rawGameTrailer = $rawg->gameTrailer($item['id']);

                if (!empty($rawGameTrailer['results'])) {
                    foreach ($rawGameTrailer['results'] as $trailer) {

                        $game->trailers()->updateOrCreate(
                            [
                                'game_id' => $game->id
                            ],
                            [
                                'name' => $trailer['name'],
                                'url'  => $trailer['data']['max'] ?? null,
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
