<?php

namespace App\Http\Controllers;

use App\Utility;
use App\User;
use App\Services\UtilityService;
use App\Services\UserService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}