<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Platform;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = [
            ['rawg_id' => 4,  'name' => 'PC',          'slug' => 'pc'],
            ['rawg_id' => 187,'name' => 'PlayStation','slug' => 'playstation'],
            ['rawg_id' => 1,  'name' => 'Xbox',        'slug' => 'xbox'],
            ['rawg_id' => 7,  'name' => 'Nintendo',   'slug' => 'nintendo'],
            ['rawg_id' => 3,  'name' => 'iOS',         'slug' => 'ios'],
            ['rawg_id' => 21, 'name' => 'Android',    'slug' => 'android'],
        ];

        foreach ($platforms as $platform) {
            Platform::updateOrCreate(
                ['rawg_id' => $platform['rawg_id']],
                $platform
            );
        }
    }
}
