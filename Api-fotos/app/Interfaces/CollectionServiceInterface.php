<?php

namespace App\Interfaces;

interface CollectionServiceInterface
{
    public function createCollection(array $data);
    public function updateCollection($id, array $data);
    public function deleteCollection($id);
    public function getCollections();
    public function getCollectionWithImages($id);
    
}
