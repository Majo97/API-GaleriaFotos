<?php

namespace App\Http\Controllers;

use App\Services\CollectionService;
use App\Http\Request\CreateCollectionRequest;
use App\Http\Request\UpdateCollectionRequest;

class CollectionController extends Controller
{

    public function createCollection(CollectionService $collectionService , CreateCollectionRequest $request)
    {
        return $collectionService->createCollection($request->validated());
    }

    public function updateCollection(CollectionService $collectionService, UpdateCollectionRequest $request, $id)
    {
        return $collectionService->updateCollection($id, $request->validated());
    }

    public function deleteCollection(CollectionService $collectionService ,$id)
    {
        return $collectionService->deleteCollection($id);
    }

    public function getCollections(CollectionService $collectionService)
    {
        return $collectionService->getCollections();
    }

    public function getCollectionWithImages(CollectionService $collectionService,$id)
    {
        return $collectionService->getCollectionWithImages($id);
    }
}
