<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Collection>
 */
class CollectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Collection::class;


    public function definition()
    {
        
        $user = User::factory()->create();
        $userId = $user-> id;

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'type_id' => $this->faker->randomElement([1, 2]),
            'owner_id' => $userId,
        ];
    }
}
