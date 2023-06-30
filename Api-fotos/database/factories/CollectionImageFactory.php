<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CollectionImage;
use App\Models\Image;
use App\Models\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CollectionImage>
 */
class CollectionImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = CollectionImage::class;

    public function definition()
    {
      
        $imageId = Image::pluck('id')->random();
        $collectionId = Collection::pluck('id')->random();

        return [
            'image_id' => $imageId,
            'collection_id' => $collectionId,
        ];
    }
}
