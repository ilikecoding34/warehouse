<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Quantity;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      User::factory(10)->create();

      for($i = 0; $i < 50; $i++){
        $item = Item::factory()->create();
        $quantity = Quantity::factory()->create(['item_id' => $item->id]);
      }

    }
}
