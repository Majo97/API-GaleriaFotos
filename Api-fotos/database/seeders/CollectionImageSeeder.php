<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CollectionImage;

class CollectionImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        CollectionImage::factory()
            ->count(20)
            ->create();
    }
}
