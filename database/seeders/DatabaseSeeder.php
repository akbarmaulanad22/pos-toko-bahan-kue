<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        Menu::Create([
            'primary_color' => 'pink',
            'secondary_color' => 'pink',
            'banner_path' => 'nojpg.jpg',
            'title' => 'nojpg.jpg',
        ]);

        Category::create([
            'image' => 'p',
            'name' => 'p',
            'slug' => 'p',
        ]);

        Product::factory(90)->create();
    }
}
