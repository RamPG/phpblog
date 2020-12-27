<?php


namespace App\Services;


use App\Services\Contracts\FileServiceInterface;

class FileService implements FileServiceInterface
{
    public function handleUploadedImage($requestData, $fieldName)
    {
        $image = '';
        if (isset($requestData[$fieldName])) {
            $image = $requestData[$fieldName]->store("images/" . date('Y-m-d'));
        }
        return $image;
    }
}
