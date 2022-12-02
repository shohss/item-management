<?php

namespace Database\Seeders;

use App\Models\Item;
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
        // アイテムを５個作る
        Item::factory()->count(5)->create();
        // \App\Models\User::factory(10)->create();
    }
}
