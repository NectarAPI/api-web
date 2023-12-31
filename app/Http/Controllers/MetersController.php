<?php

namespace App\Http\Controllers;

use App\User;
use App\Utility;
use App\Meter;

use App\Services\UserService;
use App\Services\UtilityService;
use App\Services\MeterService;

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

    public function getUtilities(Request $request) {
        $userRef = Auth::user()->ref;

        try {
            $user =  new User(new UserService());
            $utilitiesDetails = $user->fetchUtilities($userRef);
            return response()->json(['status' => [
                            'code' => 200, 
                            'message' => 'obtained user utilities'
                        ],
                        'data' => [
                            'utilities' => $utilitiesDetails
                    ]
                ]
            );

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }
    }
    
    public function getMeterTypes(Request $request) {
        try {
            $meter = new Meter(new MeterService());
            $meterTypes = $meter->getMeterTypes();

            return response()->json(['status' => ['code' => 200, 
                                                    'message' => 'obtained meter types'
                                                ],
                                                'data' => [
                                                    'meter_types' => $meterTypes
                                            ]
                                                ]);

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }
    }

    public function getSubscribers(Request $request) {
        $userRef = Auth::user()->ref;

        try {
            $utility = new Utility(new UtilityService());
            $user =  new User(new UserService());

            $subscribers = array();
            
            $utilitiesDetails = $user->fetchUtilities($userRef);

            foreach($utilitiesDetails as $utilityDetail) {
                $utilitySubscribers = $utility->getSubscribers($utilityDetail['ref']);
                $subscribers = array_merge($subscribers, $utilitySubscribers['subscribers']);

            }

            return response()->json(['status' => ['code' => 200, 
                                                    'message' => 'obtained subscribers'
                                                ],
                                                'data' => [
                                                    'subscribers' => $subscribers
                                            ]
                                        ]);

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }
    }
}