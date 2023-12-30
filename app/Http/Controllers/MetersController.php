<?php

namespace App\Http\Controllers;

use App\User;
use App\Utility;

use App\Services\UserService;
use App\Services\UtilityService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MetersController extends Controller {

    public function _construct() {
        $this->middleware('auth');
    }

    public function getSubscriberMeters(Request $request) {
        $userRef = Auth::user()->ref;

        try {
            $user =  new User(new UserService());
            $userUtilities = $user->fetchUtilities($userRef);

            $meters = array();

            foreach($userUtilities as $userUtility) {
                $utilityMeters = $userUtility['meters'];

                if (count($utilityMeters) > 0) {
                    $meters = array_merge($meters, $utilityMeters);
                }
                
            }         
 
            return response()->json(['status' => [
                            'code' => 200, 
                            'message' => 'obtained user meters'
                        ],
                        'data' => [
                            'meters' => $meters
                    ]
                ]
            );

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }
    }
}