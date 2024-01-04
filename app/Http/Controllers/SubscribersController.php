<?php

namespace App\Http\Controllers;

use App\Subscriber;

use App\Services\SubscriberService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubscribersController extends Controller {

    public function _construct() {
        $this->middleware('auth');
    }
}