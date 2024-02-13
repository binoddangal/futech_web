<?php

namespace App\Services;

use App\Services\Traits\AmazonS3;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Intervention\Image\Facades\Image;

/**
 * Class Service
 *
 * @package App\Services
 */
abstract class Service
{
    use  AmazonS3;

    protected $uploadPath = '/uploads';

    public function customPaginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public function uploadFileAndImages(UploadedFile $file, $uploadPath, $width = 320, $height = 320, $visibility, $fName = null)
    {
        $imageType = ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'ico'];

        if (!is_dir('uploads'))
            mkdir('uploads', 0775, true);

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }
        $isImage = true;
        $destination = $uploadPath;
        $file_type = $file->extension();
        $fileName = $file->hashName();
        $file_type = $file->extension();
        $newFileName = sprintf("%s.%s", (sha1($fileName) . time()), $file_type);
        if (!empty($fName))
            $newFileName = $fName . "." . $file_type;
        if (!in_array($file_type, $imageType)) {
            $isImage = false;
        }
        if ($isImage) {
            if ($file->isValid()) {
                if ($file_type == "ico") {
                    $file->move($destination, $newFileName);
                    $fileName = $newFileName;
                } else {
                    // $file->move($destination, $newFileName);
                    $image = Image::make($file);
                    $image->orientate();
                    $image->save($destination . '/' . $newFileName, 60);


                    $image = new File($destination . '/' . $newFileName);
                    if (substr($file->getClientMimeType(), 0, 5) == 'image' && $file_type != "ico")
                        $this->createThumb($image, $width, $height);
                    $fileName = $newFileName;
                }

                if (getStorageType() != 'local') {
                    $realPath = $uploadPath . "/" . $fileName;
                    $thumbPath = $uploadPath . "/thumb/" . $fileName;
                    $this->uploadToS3($uploadPath, $realPath, $thumbPath, $fileName, $visibility);
                }
                return $fileName;
            }
        } else {
            $file->move($destination, $newFileName);
            $realPath = $uploadPath . "/" . $newFileName;
            if (getStorageType() != 'local') {
                $this->uploadToS3($uploadPath, $realPath, null, $newFileName, $visibility);
            }
            return $newFileName;
        }
        return false;
    }

    public function uploadBase64($binaryImage, $width = 1170, $height = 559, $uploadPath, $visibility = 'public', $title = null)
    {
        $temFile = "uploads/temp";
        $this->uploadPath = $uploadPath;
        if (!is_dir($this->uploadPath))
            mkdir($this->uploadPath, 0775, true);


        $img = preg_replace('/^data:image\/\w+;base64,/', '', $binaryImage);
        $type = explode('/', $binaryImage)[1];
        $file_type = !empty($title) ? explode(".", $title)[1] : explode(';', $type)[0];
        $newFileName = sprintf("%s.%s", sha1(time()), $file_type);

        file_put_contents($this->uploadPath . '/' . $newFileName, base64_decode($img));
        $file = new File($this->uploadPath . '/' . $newFileName);
        if (!empty($file) && env('APP_ENV') == "local" && $file_type != "ico")
            $this->createThumb($file, 320, 320);

        $fileName = $file->getFilename();
        if (env("APP_ENV") != "local") {
            $realPath = $uploadPath . "/" . $fileName;
            $thumbPath = $uploadPath . "/thumb/" . $fileName;
            $this->uploadToS3($uploadPath, $realPath, $thumbPath, $fileName, $visibility);
        }
        return $fileName;
    }

    public function createThumb(File $file, $width = 320, $height = 320)
    {
        try {
            $img = \Intervention\Image\Facades\Image::make($file->getPathname());
            $img->fit($width, $height);
            $path = sprintf('%s/thumb/%s', $file->getPath(), $file->getFilename());
            $directory = sprintf('%s/thumb', $file->getPath());
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            $img->save($path);
        } catch (\Exception $ex) {
            return '';
        }
    }


    public function deleteFile($path, $fileName)
    {
        try {
            $imageFullPath = $path . '/' . $fileName;
            $imageThumbFullPath = $path . '/thumb/' . $fileName;
            if (is_file($imageFullPath))
                unlink($imageFullPath);
            if (is_file($imageThumbFullPath))
                unlink($imageThumbFullPath);
            if (env("APP_ENV") != "local") {
                $this->deleteFromS3($path, $fileName);
            }
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function upload($file, $uploadPath, $width = 320, $height = 320, $visibility = 'private', $fileName = null)
    {
        return $this->uploadFileAndImages($file, $uploadPath,  $width, $height, $visibility, $fileName);
    }

    public function deleteUploaded($path, $imageName)
    {
        return $this->deleteFile($path, $imageName);
    }

    public function uploadTemplateFiles($zip, $path, $folder)
    {
        if (!is_dir($path))
            mkdir($path, 0775, true);

        if (!empty($zip)) {
            $zipFile = $this->uploadZipFile($zip, $path, $folder);
            if ($zipFile) {
                $raw = explode('.', $zipFile);
                $pathName = $path . '/templates/' . $raw[0];
                if ($this->extractZip($path . '/templates/' . $zipFile, $path . '/templates')) {
                    $data['template_directory'] = $pathName;
                    unlink($path . '/templates/' . $zipFile);
                }
            }
        }
        return $data;
    }

    public function uploadZipFile(UploadedFile $file, $uploadPath, $folder)
    {
        if (!is_dir($uploadPath))
            mkdir($uploadPath);
        $destination = $uploadPath;
        if ($file->isValid()) {
            $fileName = $file->getClientOriginalName();
            $file_type = $file->getClientOriginalExtension();
            try {
                $zip = $file->move($destination, $fileName);
                return $zip->getFilename();
            } catch (\Exception $e) {
                return $e->getMessage();
                $this->logger->error(sprintf('File could not be uploaded : %s', $e->getMessage()));
            }
            return false;
        }
        return false;
    }

    function extractZip($source_file, $extract_folder)
    {
        $zip = new \ZipArchive();
        if (!$zip->open($source_file) == TRUE) {
            return false;
        }
        $zip->extractTo($extract_folder);
        $zip->close();
        return true;
    }

    public function testS3($type)
    {
        if ($type = "list_folder") {
            return $this->listFilesAndFolder($type);
        }
    }
}
