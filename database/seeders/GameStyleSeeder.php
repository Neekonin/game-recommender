<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GameStyle;
use Illuminate\Support\Str;

class GameStyleSeeder extends Seeder
{
    public function run(): void
    {
        $styles = [
            'Casual',
            'Hardcore',
            'Competitivo',
            'Narrativo',
            'Cooperativo',
            'Singleplayer',
            'Multiplayer',
        ];

        foreach ($styles as $style) {
            GameStyle::updateOrCreate(
                ['slug' => Str::slug($style)],
                [
                    'name' => $style,
                    'slug' => Str::slug($style),
                ]
            );
        }
    }
}
