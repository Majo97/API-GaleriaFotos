<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypesTableSeeder extends Seeder
{
    public function run()
    {
        $types = [
            [
                'type' => 'private',
            ],
            [
                'type' => 'public',
            ],
        ];

        Type::insert($types);
    }
}
