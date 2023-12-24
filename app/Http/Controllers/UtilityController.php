<?php

namespace App\Http\Controllers;

use App\Utility;
use App\Services\UtilityService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UtilityController extends Controller {

    public function _construct() {
        $this->middleware('auth');
    }


}