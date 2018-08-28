<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;
// configure with favored image driver (gd by default)
Image::configure(array('driver' => 'gd'));

class UploadService
{

    private const DISK = 'local';

    /**
     * Store any file on storage
     * @param UploadedFile $file
     * @param string $targetFolder
     * @return null|string
     */
    public function storeFile(UploadedFile $file, string $targetFolder)
    {
        if ($file == null)
            return null;
        $path = $file->hashName("public/$targetFolder");
        Storage::disk(self::DISK)->putFile("public/$targetFolder", $file);
        return $path;
    }

    /**
     * Save image in storage
     * @param Request $request from form
     * @return null|string - path of image saved
     */
    public function storeImage(UploadedFile $file, string $targetFolder, int $imgWidth, int $imgHeight, bool $keepProportion = true)
    {
        if ($file == null)
            return null;
        $path = $file->hashName("public/$targetFolder");
        $image = Image::make($file);
        if ($keepProportion){
            $image->resize($imgWidth, $imgHeight, function ($constraint) {
                $constraint->aspectRatio();
            });
        }else{
            $image->resize($imgWidth, $imgHeight);
        }
        Storage::disk(self::DISK)->put($path, (string)$image->encode());
        return $path;
    }

    /**
     * Save photo with a thumbnail in storage
     * @param UploadedFile $file
     * @param string $targetFolder
     * @param string $thumbFolder
     * @param int $imgWidth
     * @param int $imgHeight
     * @param int $thumbWidth
     * @param int $thumbHeight
     * @return array|null
     */
    public function storePhoto(UploadedFile $file, string $targetFolder,  string $thumbFolder, int $imgWidth, int $imgHeight, int $thumbWidth, int $thumbHeight)
    {
        if ($file == null)
            return null;
        $path = $file->hashName("public/$targetFolder");
        $image = Image::make($file);
        $image->resize($imgWidth, $imgHeight, function ($constraint) {
            $constraint->aspectRatio();
        });
        Storage::disk(self::DISK)->put($path, (string)$image->encode());
        $image->resize($thumbWidth, $thumbHeight, function ($constraint) {
            $constraint->aspectRatio();
        });
        $thumbPath = $file->hashName("public/$thumbFolder");
        Storage::disk(self::DISK)->put($thumbPath, (string)$image->encode());
        return ['path'=> $path, 'thumb_path'=> $thumbPath];
    }

    /**
     * Get a url from file or image saved on Storage
     * @param string $path - string saved in database
     * @return Storage url
     */
    public function retrieveUrl(string $path){
        if ($path == null)
            return null;
        return Storage::url($path);
    }

    /**
     * Remove file from storage
     * @param string $path of file to be removed
     * @return bool true if success
     */
    public function delete(string $path){
        return Storage::disk(self::DISK)->delete($path);
    }

}