<?php

namespace App\Http\Controllers\Managers;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class AvatarManager {
 
    public function resizeAndUploadimage(UploadedFile $imageFile, int $resizeWidth = null) {
        
        if(!is_null($imageFile)) {

            
            
            $manager = new ImageManager(new Driver());
            $fileName =  time() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile = $manager->read($imageFile)->scale(width: 300)->save(public_path('images/profile/' . $fileName));
            return 'images/profile/' . $fileName;
        }
        throw new \Exception('Invalid Image File');
    }

}