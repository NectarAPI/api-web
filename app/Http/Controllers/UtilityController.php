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

    public function getUtilities(Request $request) {
        $userRef = Auth::user()->ref;
dd($userRef);
        try {
            $utilities =  new Utility(new UtilityService());
            $utiliesDetails = $utilities->fetchUtilities($userRef);
            return response()->json(['status' => [
                            'code' => 200, 
                            'message' => 'obtained utilities data'
                        ],
                        'data' => [
                            'utilities' => $utiliesDetails
                    ]
                ]
            );

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }
    }
}