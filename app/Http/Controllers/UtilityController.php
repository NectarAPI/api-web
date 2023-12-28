<?php

namespace App\Http\Controllers;

use App\Utility;
use App\User;
use App\Services\UtilityService;
use App\Services\UserService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UtilityController extends Controller {

    public function _construct() {
        $this->middleware('auth');
    }


    public function activateDeactivateUtility(Request $request) {
        $userRef = Auth::user()->ref;
        $utilityRef = $request->utility_ref;
        $utility = new Utility(new UtilityService());

        try {
            if (!is_null($utilityRef)) { 

                $user =  new User(new UserService());
                $utilityDetails = $user->fetchUtilities($userRef);
     
                foreach($utilityDetails as $currUtility) {

                    if ($currUtility['ref'] == $utilityRef) {

                        if ($currUtility['activated']) {
                            $updatedUtility = $utility->deactivateUtility($utilityRef, $userRef);

                        } else {
                            $updatedUtility = $utility->activateUtility($utilityRef, $userRef);

                        }

                        $message = $currUtility['activated'] ? 'Deactivated utility' : 'Activated utility';

                        return response()->json(['status' => [
                                                                'code' => 200, 
                                                                'message' => $message
                                                            ],
                                                            'data' => [
                                                                'utility' => $updatedUtility
                                                        ]
                                                    ]
                                                );
                    }
                }

                throw new \Exception(sprintf('utility ref %s not assigned to user', $utilityRef));                

            }

            throw new \Exception('Missing utility ref');

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

    public function updateUtility(Request $request) {
        $this->validator($request->all())->validate();

        $userRef = Auth::user()->ref;
        $utilityRef = $request->utility_ref;

        $utility = new Utility(new UtilityService());

        try {
            if (!is_null($utilityRef)) { 

                $user =  new User(new UserService());
                $utilityDetails = $user->fetchUtilities($userRef);
     
                foreach($utilityDetails as $currUtility) {

                    if ($currUtility['ref'] == $utilityRef) {

                        $name = $request->name;
                        $contactPhoneNo = $request->contact_phone_no;
                        $unitCharge = $request->unit_charge;
                        $configRef = $request->configuration;
                        $activated = $request->activated == 'on' ? true : false;

                        $updatedUtility = $utility->updateUtility($userRef, $utilityRef, $name, $contactPhoneNo, 
                                                                    $unitCharge, $configRef, $activated);

                        return response()->json(['status' => [
                                                                'code' => 200, 
                                                                'message' => 'Updated utility'
                                                            ],
                                                            'data' => [
                                                                'utility' => $updatedUtility
                                                        ]
                                                    ]
                                                );
                    }
                }
                
            }

            throw new \Exception('Missing utility ref for user');

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

    private function validator(array $data) {
        
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'contact_phone_no' => ['required', 'regex:/^[0-9]*$/u'],
            'unit_charge' => ['required', 'regex:/^\d*(\.\d{1,2})?$/'],
            'configuration' => ['required', 'string', 'min:1', 'max:255'],
        ],
        [
            'name.required' => 'The :attribute is required',
            'name.string' => 'The :attribute cannot be greater than 255 characters',
            'name.min' => 'The :attribute cannot be less than 1 character',
            'name.max' => 'The :attribute cannot be greater than 255 characters',
            'contact_phone_no.required' => 'The :attribute field is required',
            'contact_phone_no.regex' => 'The :attribute format is invalid',
            'unit_charge.required' => 'The :attribute field is required',
            'unit_charge.regex' => 'The :attribute must be an integer with 2 decimal points',
            'configuration.required' => 'The :attribute is required',
            'configuration.string' => 'The :attribute must be an alphanumeric string',
            'configuration.min' => 'The :attribute cannot be less than 1 character',
            'configuration.max' => 'The :attribute cannot be greater than 255 characters',
        ]);
    }
}