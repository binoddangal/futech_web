<?php

namespace App\Services\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait AmazonS3
{
    protected $disk = "wasabi";

    public function uploadToS3($uploadPath, $realPath, $thumbPath = null, $fileName = null, $visibility)
    {
        setStorageConfig();
        $storageType = getStorageType();
        $s3 = Storage::disk($storageType);

        $uploadPathReal = $uploadPath . "/" . $fileName;
        $uploadPathThumb = $uploadPath . "/thumb/" . $fileName;

        $uploadPathReal = buildUploadPathUrl($uploadPathReal);
        $uploadPathThumb = buildUploadPathUrl($uploadPathThumb);

        $this->createFolder($uploadPath);

        if (!empty($realPath) && is_file($realPath)) {
            $s3->put($uploadPathReal, \File::get($realPath), $visibility);
        }
        if (!empty($thumbPath) && is_file($thumbPath)) {
            $s3->put($uploadPathThumb, \File::get($thumbPath), $visibility);
        }

        if (is_file($realPath))
            \File::delete($realPath);

        if (is_file($thumbPath))
            \File::delete($thumbPath);
        return $s3->url($uploadPathReal);
    }

    public function createFolder($path)
    {
        $s3 = Storage::disk($this->disk);
        if (!$s3->exists($path)) {
            return $s3->makeDirectory($path);
        }
        return null;
    }

    public
    function deleteFromS3($uploadPath, $imageName)
    {
        setStorageConfig();
        $storageType = getStorageType();
        $s3 = Storage::disk($storageType);
        $path = [];
        $parentPath = $uploadPath . '/' . $imageName;
        $thumbPath = $uploadPath . '/thumb/' . $imageName;
        $parentPath = buildUploadPathUrl($parentPath);
        $thumbPath = buildUploadPathUrl($thumbPath);
        if (!empty($parentPath)) {
            array_push($path, $parentPath);
        }

        if (!empty($parentPath)) {
            array_push($path, $thumbPath);
        }
        if (sizeof($path) > 0) {
            $s3->delete($path);
        }
        return true;
    }

    public
    function createThumbS3($file, $width = 320, $height = 320)
    {
        $imageFile = \Image::make($file)->resize($width, $height)->stream();
        $imageFile = $imageFile->__toString();
        return $imageFile;
    }

    public
    function uploadFile($file, $path)
    {
        $imageName = null;
        if ($file->isValid()) {
            $fileName = $file->getClientOriginalName();
            $file_type = $file->getClientOriginalExtension();
            $s3 = Storage::disk($this->disk);
            $newFileName = sprintf("%s.%s", sha1($fileName . time()), $file_type);
            $response = $s3->putFileAs($path, $file, $newFileName, 'public');
            return $newFileName;
        }
        return false;
    }

    public
    function deleteFileFromS3($file, $path)
    {
        setStorageConfig();
        $storageType = getStorageType();
        $s3 = Storage::disk($storageType);
        $parentPath = $path . '/' . $path;
        if ($s3->exists($parentPath)) {
            return $s3->readAndDelete($parentPath);
        }
    }


    public
    function setFolderPermission()
    {
        setStorageConfig();
        $storageType = getStorageType();
        $s3 = Storage::disk($storageType);
        $directoryArray = $s3->allDirectories();
        if (sizeof($directoryArray) > 0) {
            foreach ($directoryArray as $index => $dirPath) {
                $s3->setVisibility($dirPath, 'public');
            }
        }
        return true;
    }


    public
    function setFilePermission()
    {
        setStorageConfig();
        $storageType = getStorageType();
        $s3 = Storage::disk($storageType);
        $fileArray = $s3->allFiles();
        foreach ($fileArray as $i => $file) {
            if (!Str::contains($file, '.jpeg') && !Str::contains($file, '.png') && !Str::contains($file, '.jpg')) {
                unset($fileArray[$i]);
            }
        }
        if (sizeof($fileArray) > 0) {
            foreach ($fileArray as $index => $filePath) {
                $s3->setVisibility($filePath, 'public');
            }
        }
        return true;
    }

    function listFilesAndFolder($type)
    {
        setStorageConfig();
        $storageType = getStorageType();
        $s3 = Storage::disk($storageType);
        if ($type == "files") {
            return $s3->allDirectories();
        } else {
            return $s3->allFiles();
        }
    }
}
