<?php

namespace App\Http\Controllers;

use App\Http\Request\CreateImageRequest;
use App\Http\Request\UpdateImageRequest;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function create( CreateImageRequest $request, ImageService $imageService)
    {
        return $imageService->createImage($request-> validated());
    }

    public function update(ImageService $imageService, UpdateImageRequest $request, $id)
    {
        return $imageService->updateImage($request->validated(), $id);
    }

    public function delete(ImageService $imageService, $id)
    {
        return $imageService->deleteImage($id);
    }

    public function addImagesToCollection(ImageService $imageService, Request $request, $collectionId)
    {
        $data = [
            'imageIds' => $request->input('image_ids'),
        ];

        return $imageService->addImagesToCollection($data, $collectionId);
    }

    public function deleteImagesFromCollection(ImageService $imageService, $collectionId, Request $request)
    {
        $data = [
            'imageIds' => $request->input('image_ids'),
        ];

        return $imageService->deleteImagesFromCollection($collectionId, $data);
    }
    
}
