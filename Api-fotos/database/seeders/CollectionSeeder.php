<?php

namespace Database\Seeders;
use App\Models\Collection;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */  public function run()
    {
        Collection::factory()
            ->count(10)
            ->create();
    }
}
