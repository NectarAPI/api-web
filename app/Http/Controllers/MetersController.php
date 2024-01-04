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

                foreach($userUtility['meters'] as $userUtilityMeter) {
                    $userUtilityMeter['utility']['name'] = $userUtility['name'];
                    $userUtilityMeter['utility']['ref'] = $userUtility['ref'];
                    $userUtilityMeter['utility']['activated'] = $userUtility['activated'];

                    array_push($meters, $userUtilityMeter);
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

    public function updateMeter(Request $request) {
        $this->validator($request->all())->validate();

        $userRef = Auth::user()->ref;

        try {
            $meter = new Meter(new MeterService());

            $meterRef = $request->meter_ref;
            $meterNo = $request->meter_no;
            $utility = $request->utility;
            $type = $request->type;
            $subscriber = $request->subscriber;
            $activated = $request->activated == 'on' ? true : false;

            $updatedMeter = $meter->updateMeter($meterRef, $userRef, $meterNo, $utility, 
                                                    $type, $subscriber, $activated);
                                                    return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => 'updated meter'
                                                    ],
                                                    'data' => [
                                                        'meter' => $updatedMeter
                                                ]
                                            ]
                                        );

        } catch (\Exception $e) {
           if ($e instanceof \Illuminate\Validation\ValidationException) {

                $errors = $e->errors();
 
                foreach ($errors as $key =>  $value) {
                     $arrImplode[] = implode( ', ', $errors[$key] );
                 }
 
                 $message = implode(', ', $arrImplode);
         
             } else {
                 $message =  $e->getMessage();
             }
             
             return response()->json(['status' => [
                                                    'code' => 500, 
                                                    'message' => $message
                                                ]
                                            ]);

        }    
    }


    public function createMeter(Request $request) {
        $this->validator($request->all())->validate();

        $userRef = Auth::user()->ref;
        try {
            $meter = new Meter(new MeterService());

            $meterNo = $request->meter_no;
            $utility = $request->utility;
            $type = $request->type;
            $subscriber = $request->subscriber;

            $createdMeter = $meter->createMeter($userRef, $meterNo, $utility, $type, $subscriber);
                                                    return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => 'created meter'
                                                    ],
                                                    'data' => [
                                                        'meter' => $createdMeter
                                                ]
                                            ]
                                        );

        } catch (\Exception $e) {
           if ($e instanceof \Illuminate\Validation\ValidationException) {

                $errors = $e->errors();
 
                foreach ($errors as $key =>  $value) {
                     $arrImplode[] = implode( ', ', $errors[$key] );
                 }
 
                 $message = implode(', ', $arrImplode);
         
             } else {
                 $message =  $e->getMessage();
             }
             
             return response()->json(['status' => [
                                                    'code' => 500, 
                                                    'message' => $message
                                                ]
                                            ]);

        }    
    }

    public function activateDeactivateMeter(Request $request) {
        $userRef = Auth::user()->ref;
        $meterRef = $request->meter_ref;

        $meter = new Meter(new MeterService());

        try {
            $user =  new User(new UserService());
            $userUtilities = $user->fetchUtilities($userRef);

            $meters = array();

            foreach($userUtilities as $userUtility) {

                foreach($userUtility['meters'] as $userUtilityMeter) {
                    
                    if ($userUtilityMeter['ref'] == $meterRef) {

                        if ($userUtilityMeter['activated']) {
                            $updatedMeter = $meter->deactivateMeter($meterRef, $userRef);

                        } else {
                            $updatedMeter = $meter->activateMeter($meterRef, $userRef);

                        }

                        $message = $userUtilityMeter['activated'] ? 'Deactivated meter' : 'Activated meter';

                        return response()->json(['status' => [
                                                                'code' => 200, 
                                                                'message' => $message
                                                            ],
                                                            'data' => [
                                                                'meter' => $updatedMeter
                                                        ]
                                                    ]
                                                );
                    }
                }

                throw new \Exception('Invalid meter ref');
                
            }        

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }
    }

    private function validator(array $data) {
        
        return Validator::make($data, [
            'meter_no' => ['required', 'regex:/^([0-9]){11}$|^([0-9]){13}$/u'],
            'utility' => ['required', 'string', 'min:1', 'max:255'],
            'type' => ['required', 'string', 'min:1', 'max:255'],
            'subscriber' => ['string', 'min:1', 'max:255'],
        ],
        [
            'meter_no.required' => 'The :attribute is required',
            'meter_no.regex' => 'The :attribute must be an 11 and 13 digit number',
            'utility.required' => 'The :attribute field is required',
            'utility.string' => 'The :attribute cannot be greater than 255 characters',
            'utility.min' => 'The :attribute cannot be less than 1 character',
            'utility.max' => 'The :attribute cannot be greater than 255 characters',
            'type.required' => 'The :attribute field is required',
            'type.string' => 'The :attribute cannot be greater than 255 characters',
            'type.min' => 'The :attribute cannot be less than 1 character',
            'type.max' => 'The :attribute cannot be greater than 255 characters',
            'subscriber.string' => 'The :attribute cannot be greater than 255 characters',
            'subscriber.min' => 'The :attribute cannot be less than 1 character',
            'subscriber.max' => 'The :attribute cannot be greater than 255 characters',
           
        ]);
    }
}