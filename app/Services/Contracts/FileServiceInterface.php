<?php


namespace App\Services\Contracts;

interface FileServiceInterface
{
    public function handleUploadedImage($requestData, $fieldName);
}
