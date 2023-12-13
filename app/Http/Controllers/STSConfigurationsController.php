<?php

namespace App\Http\Controllers;

use App\STSConfiguration;
use App\Services\ConfigService;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class STSConfigurationsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }


    public function getConfigs(Request $request) {
        try {
            $userRef = Auth::user()->ref;

            if (!is_null($userRef)) {
                $stsConfig = new STSConfiguration(new ConfigService());
                $stsConfigDetails = $stsConfig->fetchSTSConfigurations($userRef);
                return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => 'obtained sts configurations data'
                                                     ],
                                                    'data' => [
                                                        'sts_configurations' => $stsConfigDetails
                                                ]
                                            ]
                                        );
            }
            
            throw new \Exception('User ref not found');

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }   
    }

    public function addConfig(Request $request) {
        try {
            $data = $request->data;
            $digest = $request->digest;
            $key = $request->key;
            $userRef = Auth::user()->ref;

            if (!is_null($data) && !is_null($digest) && !is_null($key)) {

                if (!is_null($userRef)) {
                    $stsConfig = new STSConfiguration(new ConfigService());
                    $stsConfigDetails = $stsConfig->addSTSConfigurations($userRef, $data, $digest, $key);

                    return response()->json(['status' => [
                                                            'code' => 200, 
                                                            'message' => 'created sts configuration'
                                                        ],
                                                        'data' => [
                                                            'sts_configurations' => $stsConfigDetails
                                                    ]
                                                ]
                                            );
                }
                
                throw new \Exception('User ref not found');
            }

            throw new \Exception('Missing data, digest or key');

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

    public function setConfigStatus(Request $request) {
        try {
            $configRef = $request->route('config_ref');
            $status = $request->status;
            $userRef = Auth::user()->ref;

            if (!is_null($configRef)) {
                if (!is_null($status)) {
                    $stsConfig = new STSConfiguration(new ConfigService());
                    $stsConfigActivateStatus = $stsConfig->setConfigStatus($configRef, $status, $userRef);

                    return response()->json(['status' => [
                                                            'code' => 200, 
                                                            'message' => $stsConfigActivateStatus
                                                        ]
                                                ]
                                            );
                }
                throw new \Exception('Invalid config status');
            }
            throw new \Exception('Invalid config ref');
            
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
