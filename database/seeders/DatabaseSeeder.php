<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Super Admin'
        ]);

        Role::create([
            'name' => 'Admin'
        ]);

        Role::create([
            'name' => 'Cashieer'
        ]);
        
        User::create([
            'name' => 'Dewi',
            'email' => 'dewi12@tokoazka.com',
            'password' => Hash::make('tokoazka9090'),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'Soni',
            'email' => 'soni89@tokoazka.com',
            'password' => Hash::make('tokoazka44'),
            'role_id' => 2
        ]);
        
        User::create([
            'name' => 'Ade',
            'email' => 'ade882@tokoazka.com',
            'password' => Hash::make('tokoazka77'),
            'role_id' => 3
        ]);

        Menu::Create([
            'primary_color' => 'pink',
            'secondary_color' => 'pink',
            'banner_path' => 'nojpg.jpg',
            'title' => 'nojpg.jpg',
        ]);

        Category::create([
            'image' => '',
            'name' => 'Makanan',
            'slug' => 'makanan',
        ]);

        Product::factory(10)->create();

        ProductSize::factory(100)->create();
    }
}
