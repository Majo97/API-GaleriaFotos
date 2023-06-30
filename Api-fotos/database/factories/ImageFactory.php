<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Image;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Image::class;

    public function definition()
    {
      
         $user = User::factory()->create();
         $userId = $user-> id;
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'type_id' => $this->faker->randomElement([1, 2]),
            'owner_id' => $userId,
            'path' => $this->faker->imageUrl,
            'disk' => 'public', 
        ];
    }
}
