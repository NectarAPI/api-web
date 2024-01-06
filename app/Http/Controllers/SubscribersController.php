<?php

namespace App\Http\Controllers;

use App\Subscriber;
use App\Utility;
use App\User;

use App\Services\SubscriberService;
use App\Services\UserService;
use App\Services\UtilityService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubscribersController extends Controller {

    public function _construct() {
        $this->middleware('auth');
    }

    public function getSubscribers(Request $request) {
        $userRef = Auth::user()->ref;

        try {
            if (!is_null($userRef)) {
                $user = new User(new UserService());
                $userUtilities = $user->fetchUtilities($userRef);

                $utility = new Utility(new UtilityService());

                $subscribers = array();

                foreach ($userUtilities as $userUtility) {
                    $currUtilitySubscribers = $utility->getSubscribers($userUtility['ref']);

                    if (count($currUtilitySubscribers) > 0) {
                        $subscribers = array_merge($subscribers, $currUtilitySubscribers);
                    }
                }

                return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => 'obtained subscribers data'
                                                    ],
                                                    'data' => [
                                                        'subscribers' => $subscribers
                                                ]
                                            ]
                                        );
            }

        } catch(\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);
            
        }  
   
    }
}