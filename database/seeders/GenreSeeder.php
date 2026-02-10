<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['rawg_id' => 4,  'name' => 'Action',     'slug' => 'action'],
            ['rawg_id' => 3,  'name' => 'Adventure',  'slug' => 'adventure'],
            ['rawg_id' => 5,  'name' => 'RPG',        'slug' => 'rpg'],
            ['rawg_id' => 10, 'name' => 'Strategy',   'slug' => 'strategy'],
            ['rawg_id' => 2,  'name' => 'Shooter',    'slug' => 'shooter'],
            ['rawg_id' => 14, 'name' => 'Simulation', 'slug' => 'simulation'],
            ['rawg_id' => 7,  'name' => 'Puzzle',     'slug' => 'puzzle'],
            ['rawg_id' => 40, 'name' => 'Casual',     'slug' => 'casual'],
        ];

        foreach ($genres as $genre) {
            Genre::updateOrCreate(
                ['rawg_id' => $genre['rawg_id']],
                $genre
            );
        }
    }
}
