<?php

namespace App\Http\Utils;

use Webpatser\Uuid\Uuid;

class UuidUtils {

    public static function generate() {
        return Uuid::generate(4)->string;
    }
}