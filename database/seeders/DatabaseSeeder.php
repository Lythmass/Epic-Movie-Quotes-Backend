<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $genres = collect([
            'Action',
            'Adventure',
            'Romance',
            'Drama',
            'Sci-Fi',
            'Documentary',
            'Comedy',
            'Detective',
            'Anime',
            'Fantasy',
            'Horror'
        ]);

        $genres->map(
            fn ($genre) =>
                Genre::factory(1)->create([
                    'name' => $genre
                ])
        );
    }
}
