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
            'message' => 'Collection created successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'code' => 500,
            'message' => 'Failed to create collection',
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
            'message' => 'Collection updated successfully'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'code' => 500,
            'message' => 'Failed to update collection',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function getMyCollections(){
    try {
        $userId = Auth::id();
        $collections = Collection::where('owner_id', $userId)
            ->get(['id', 'title', 'description', 'owner_id', 'type_id'])
            ->load('owner:id,name')
            ->load('type:id,type');
        $collections->transform(function ($collection) {
            $collection->owner = $collection->owner->only(['name']);
            $collection->type = $collection->type->only(['type']);
            unset($collection->owner_id, $collection->type_id);
            return $collection;
        });
    

        return response()->json([
            'code' => 200,
            'message' => 'Collections retrieved successfully',
            'data' => $collections,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'code' => 500,
            'message' => 'Failed to retrieve collections',
            'error' => $e->getMessage(),
        ], 500);
    }
}
    public function getCollections()
{
    try {
        $userId = Auth::id();
        $collections = Collection::whereIn('type_id', [1, 2])
            ->where(function ($query) use ($userId) {
                $query->where('owner_id', $userId)
                    ->orWhere('type_id', 2);
            })
            ->get(['id', 'title', 'description', 'owner_id', 'type_id'])
            ->load('owner:id,name')
            ->load('type:id,type');
        $collections->transform(function ($collection) {
            $collection->owner = $collection->owner->only(['name']);
            $collection->type = $collection->type->only(['type']);
            unset($collection->owner_id, $collection->type_id);
            return $collection;
        });
    

        return response()->json([
            'code' => 200,
            'message' => 'Collections retrieved successfully',
            'data' => $collections,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'code' => 500,
            'message' => 'Failed to retrieve collections',
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function getCollectionWithImages($id)
{
    try {
        $collection = Collection::with('owner:id,name', 'images:id,title,description,path')
            ->findOrFail($id);

        $isOwner = ($collection-> owner_id == Auth::id());

        $filteredImages = $collection->images->filter(function ($image) use ($isOwner) {
            return ($image->type_id == 2 || $isOwner);
        });

        return response()->json([
            'code' => 200,
            'message' => 'Collection retrieved successfully',
            'data' => [
                'id' => $collection->id,
                'title' => $collection->title,
                'description' => $collection->description,
                'owner' => $collection->owner,
                'images' => $filteredImages,
            ],
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'code' => 500,
            'message' => 'Failed to retrieve collection',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}




