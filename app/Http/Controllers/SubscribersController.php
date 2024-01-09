<?php

namespace App\Http\Controllers;

use App\Subscriber;
use App\Utility;
use App\User;

use App\Services\SubscribersService;
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

    public function createSubscriber(Request $request) {
        $userRef = Auth::user()->ref;
        $subscriber = new Subscriber(new SubscribersService());

        try {
            if (!is_null($userRef)) {
                $name = $request->name;
                $contactPhoneNo = $request->phone_no;
                $utility = $request->utility;

                $createdSubscriber = $subscriber->addSubscriber($userRef, $name, $contactPhoneNo, $utility);

                return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => 'Created subscriber'
                                                    ],
                                                        'data' => [
                                                        'subscriber' => $createdSubscriber
                                                    ]
                                                ]);


            }

        } catch(\Exception $e) {
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

    public function activateDeactivateSubscriber(Request $request) {
        $userRef = Auth::user()->ref;
        $subscriberRef = $request->subscriber_ref;
        $subscriber = new Subscriber(new SubscribersService());

        try {
            if (!is_null($subscriberRef)) { 

                $user =  new User(new UserService());
                $utilityDetails = $user->fetchUtilities($userRef);

                foreach($utilityDetails as $currUtility) {

                    foreach ($currUtility['subscribers'] as $currSubscriber) {
                        if ($currSubscriber['ref'] == $subscriberRef) {

                            if ($currSubscriber['activated']) {
                                $updatedSubscriber = $subscriber->deactivateSubscriber($subscriberRef, $userRef);
        
                            } else {
                                $updatedSubscriber = $subscriber->activateSubscriber($subscriberRef, $userRef);
        
                            }
                            $message = $currSubscriber['activated'] ? 'Deactivated subscriber' : 'Activated subscriber';

                            return response()->json(['status' => [
                                                                    'code' => 200, 
                                                                    'message' => $message
                                                                ],
                                                                'data' => [
                                                                    'utility' => $updatedSubscriber
                                                                ]
                                                            ]
                                                        );

                        }
                    }
                }

                throw new \Exception(sprintf('utility ref %s not assigned to user', $utilityRef));                

            }

            throw new \Exception('Missing subscriber ref');            

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