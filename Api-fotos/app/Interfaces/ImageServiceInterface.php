<?php
namespace App\Interfaces;

interface ImageServiceInterface
{
    public function createImage(array $data);

    public function updateImage(array $data, $id);

    public function deleteImage($id);

    public function addImagesToCollection(array $imageIds,$collectionId );

    public function deleteImagesFromCollection($collectionId, array $imageId);
}
