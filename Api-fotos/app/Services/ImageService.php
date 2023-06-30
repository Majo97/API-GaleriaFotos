<?php

namespace App\Services;

use App\Models\Collection;
use App\Models\Image;
use App\Interfaces\ImageServiceInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageService implements ImageServiceInterface
{
    public function createImage(array $data)
    {
        try {
            $data['owner_id'] = Auth::id();
            $imagePath = $data['image']->store('images', 'public');
            $data['path'] = $imagePath;
            $data['disk'] = 'public';

            $image = Image::create($data);

            return response()->json([
                'code' => 200,
                'message' => 'Image created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Failed to create image',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function updateImage(array $data, $imageId)
{
    try {
        // Obtener el objeto de imagen utilizando el ID
        $image = Image::findOrFail($imageId);

        // Verificar si el usuario autenticado es el propietario de la imagen
        if ($image->owner_id !== Auth::id()) {
            return response()->json([
                'code' => 403,
                'message' => 'Unauthorized',
            ], 403);
        }
        $image->update($data);

        return response()->json([
            'code' => 200,
            'message' => 'Image updated successfully',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'code' => 500,
            'message' => 'Failed to update image',
            'error' => $e->getMessage(),
        ], 500);
    }
}


public function deleteImage($image)
{
    try {
        $image = Image::findOrFail($image); 

        if ($image->owner_id !== Auth::id()) {
            return response()->json([
                'code' => 403,
                'message' => 'Unauthorized',
            ], 403);
        }

        $image->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Image deleted successfully',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'code' => 500,
            'message' => 'Failed to delete image',
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function addImagesToCollection(array $data, $collectionId)
{
    try {
        $collection = Collection::findOrFail($collectionId);

        if ($collection->owner_id !== Auth::id()) {
            return response()->json([
                'code' => 403,
                'message' => 'You are not authorized to perform this action'
            ], 403);
        }

        $imageIds = $data['imageIds'];

        if (empty($imageIds) || !is_array($imageIds)) {
            return response()->json([
                'code' => 400,
                'message' => 'No images specified'
            ], 400);
        }

        $existingImages = $collection->images()->pluck('images.id')->toArray();
        $existingImageIds = [];

        foreach ($imageIds as $imageId) {
            if (in_array($imageId, $existingImages)) {
                $existingImageIds[] = $imageId;
            }
        }

        if (!empty($existingImageIds)) {
            return response()->json([
                'code' => 400,
                'message' => 'One or more images already exist in the collection',
                'existingImages' => $existingImageIds
            ], 400);
        }

        $collection->images()->attach($imageIds);

        return response()->json([
            'code' => 200,
            'message' => 'Images added to collection successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'code' => 500,
            'message' => 'Failed to add images to collection',
            'error' => $e->getMessage()
        ], 500);
    }
}


public function deleteImagesFromCollection($collectionId, array $data)
{
    try {
        $collection = Collection::findOrFail($collectionId);
        $imageIds = $data['imageIds'];

        if (!is_array($imageIds) || empty($imageIds)) {
            return response()->json([
                'code' => 400,
                'message' => 'Invalid image IDs provided'
            ], 400);
        }

        if ($collection->owner_id !== Auth::id()) {
            return response()->json([
                'code' => 403,
                'message' => 'You are not authorized to perform this action'
            ], 403);
        }

        $associatedImageIds = $collection->images()->pluck('image_id')->toArray();

        $invalidImageIds = array_diff($imageIds, $associatedImageIds);

        if (!empty($invalidImageIds)) {
            return response()->json([
                'code' => 400,
                'message' => 'One or more image IDs do not belong to the collection',
                'invalidImageIds' => $invalidImageIds
            ], 400);
        }

        $collection->images()->detach($imageIds);

        return response()->json([
            'code' => 200,
            'message' => 'Images removed from collection successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'code' => 500,
            'message' => 'Failed to remove images from collection',
            'error' => $e->getMessage()
        ], 500);
    }
}


}
