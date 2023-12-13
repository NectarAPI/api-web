<?php

namespace App\Http\Controllers\Managers;

use Illuminate\Http\UploadedFile;
use Storage;
use Intervention\Image\ImageManagerStatic as Image;

class AvatarManager {

    public function resizeAndUploadimageToS3(UploadedFile $imageFile, int $resizeWidth = null) {
        
        if(!is_null($imageFile)) {

            $extension = $imageFile->getClientOriginalExtension();

            $fileName = time() . '.' . $extension;

            if (!is_null($resizeWidth)) { 
                $imageFile = Image::make($imageFile)->resize($resizeWidth, null, function ($constraint) {$constraint->aspectRatio();})->stream();
                $imageFile = $imageFile->__toString();

            } else {
                $imageFile = file_get_contents($imageFile->getRealPath());
                
            }
    
            $s3 = Storage::disk('s3');
            $s3->put($fileName, $imageFile, 'public');
            
            return $fileName;
        }
        throw new \Exception('Invalid Image File');
    }

}