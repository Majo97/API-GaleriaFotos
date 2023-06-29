<?php

namespace App\Services;

use App\Models\Collection;
use App\Models\Image;
use App\Interfaces\ImageServiceInterface;
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
            if ($image->owner_id !== Auth::id()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Unauthorized',
                ], 403);
            }

            Storage::disk($image->disk)->delete($image->path);
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

    public function addImagesToCollection($collectionId, $imageIds)
    {
        try {
            $collection = Collection::findOrFail($collectionId);

            if ($collection->owner_id !== Auth::id()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'You are not authorized to perform this action'
                ], 403);
            }

            if (empty($imageIds) || !is_array($imageIds)) {
                return response()->json([
                    'code' => 400,
                    'message' => 'No images specified'
                ], 400);
            }

            $existingImages = Image::whereIn('id', $imageIds)->pluck('id');

            if (count($imageIds) !== count($existingImages)) {
                return response()->json([
                    'code' => 400,
                    'message' => 'One or more images not found'
                ], 400);
            }

            $userImageIds = Image::where('owner_id', Auth::id())->pluck('id')->toArray();

            $newImages = array_intersect($imageIds, $userImageIds);

            $alreadyAssociated = $collection->images()->whereIn('image_id', $newImages)->pluck('image_id')->toArray();

            $newImages = array_diff($newImages, $alreadyAssociated);

            $collection->images()->attach($newImages);

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

    public function deleteImagesFromCollection($collectionId, $imageId)
    {
        try {
            $collection = Collection::findOrFail($collectionId);
            $image = Image::findOrFail($imageId);

            if ($collection->owner_id !== Auth::id()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'You are not authorized to perform this action'
                ], 403);
            }

            $collection->images()->detach($imageId);

            return response()->json([
                'code' => 200,
                'message' => 'Image removed from collection successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Failed to remove image from collection',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
