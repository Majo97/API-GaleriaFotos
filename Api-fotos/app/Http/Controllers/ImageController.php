<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function create(Request $request)
{
    try {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'type_id' => 'required|integer',
            'image' => 'required|image',
            'collections' => 'array', // Opcional, si deseas asociar la imagen con colecciones específicas
        ]);

        $data = $request->all();
        $data['owner_id'] = Auth::id();

        // Almacenar la imagen en disco
        $imagePath = $request->file('image')->store('images', 'public');
        $data['path'] = $imagePath;
        $data['disk'] = 'public';

        // Crear la imagen
        $image = Image::create($data);

        // Asociar la imagen con las colecciones si se especificaron
        if (isset($data['collections']) && is_array($data['collections'])) {
            $collectionIds = $data['collections'];
            $collectionUuids = array_map(fn ($id) => Uuid::fromString($id), $collectionIds);
            $collections = Collection::whereIn('id', $collectionUuids)->get();
            $image->collections()->sync($collections);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Image created successfully',
            'data' => $image,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'code' => 500,
            'message' => 'Failed to create image',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'string',
                'description' => 'string',
                'type_id' => 'integer',
                'collections' => 'array', // Opcional, si deseas actualizar las colecciones asociadas a la imagen
            ]);

            $image = Image::findOrFail($id);

            if ($image->owner_id !== Auth::id()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'You are not authorized to update this image',
                ], 403);
            }

            $data = $request->all();

            // Actualizar la imagen
            $image->update($data);

            // Actualizar las colecciones asociadas si se especificaron
            if (isset($data['collections']) && is_array($data['collections'])) {
                $collectionIds = $data['collections'];
                $collections = Collection::whereIn('id', $collectionIds)->get();
                $image->collections()->sync($collections);
            }

            return response()->json([
                'code' => 200,
                'message' => 'Image updated successfully',
                'data' => $image,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Failed to update image',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $image = Image::findOrFail($id);
    
            if ($image->owner_id !== Auth::id()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'You are not authorized to delete this image',
                ], 403);
            }
    
            // Soft delete de la imagen
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
    
}
