<?php
namespace App\Services;

use App\Models\Collection;
use App\Interfaces\CollectionServiceInterface;
use Illuminate\Support\Facades\Auth;

class CollectionService implements CollectionServiceInterface
{
    public function createCollection(array $data)
    {
        try {
            $data['owner_id'] = Auth::id();

            $collection = Collection::create($data);
            $collection->createActivityLog('created');

            return response()->json([
                'code' => 200,
                'message' => 'Collection created successfully',
                'data' => $collection,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Failed to create collection',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateCollection($id, array $data)
    {
        try {
            $collection = Collection::findOrFail($id);

            if ($collection->owner_id !== Auth::id()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'You are not authorized to update this collection',
                ], 403);
            }

            $collection->update($data);
            $collection->createActivityLog('updated');

            return response()->json([
                'code' => 200,
                'message' => 'Collection updated successfully',
                'data' => $collection,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Failed to update collection',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteCollection($id)
    {
        try {
            $collection = Collection::findOrFail($id);

            if ($collection->owner_id !== Auth::id()) {
                return response()->json([
                    'code' => 403,
                    'message' => 'You are not authorized to delete this collection',
                ], 403);
            }

            $collection->delete();
            $collection->createActivityLog('deleted');

            return response()->json([
                'code' => 200,
                'message' => 'Collection deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Failed to delete collection',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getPublicCollections()
    {
        try {
            $publicCollections = Collection::where('type_id', 2)
                ->get(['id', 'title', 'description', 'owner_id'])
                ->load('owner:id,name');
    
            // Modificar la estructura de la respuesta para mostrar solo el nombre del propietario
            $publicCollections->transform(function ($collection) {
                $collection->owner = $collection->owner->only(['id', 'name']);
                unset($collection->owner_id);
                return $collection;
            });
    
            return response()->json([
                'code' => 200,
                'message' => 'Public collections retrieved successfully',
                'data' => $publicCollections,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Failed to retrieve public collections',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function getPrivateCollections()
    {
        try {
            $userId = Auth::id();
    
            $privateCollections = Collection::where('owner_id', $userId)
                ->get(['id', 'title', 'description', 'owner_id'])
                ->load('owner:id,name');
    
            // Modificar la estructura de la respuesta para mostrar solo el nombre del propietario
            $privateCollections->transform(function ($collection) {
                $collection->owner = $collection->owner->only(['id', 'name']);
                unset($collection->owner_id);
                return $collection;
            });
    
            return response()->json([
                'code' => 200,
                'message' => 'Private collections retrieved successfully',
                'data' => $privateCollections,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Failed to retrieve private collections',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}