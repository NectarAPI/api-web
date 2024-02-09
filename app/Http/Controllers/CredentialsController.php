<?php

namespace App\Http\Controllers;

use App\Credentials;
use App\Services\CredentialsService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CredentialsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function getPermissions(Request $request) {
        try {
            $credentials = new Credentials(new CredentialsService());
            $permissions = $credentials->getPermissions();
            return response()->json(['status' => [
                                                    'code' => 200, 
                                                    'message' => 'obtained permissions data'
                                                 ],
                                                'data' => [
                                                    'permissions' => $permissions
                                            ]
                                        ]
                                    );
        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }  
    }

    public function getCredentials(Request $request) {
        $userRef = Auth::user()->ref;

        try {
            $credentials = new Credentials(new CredentialsService());
            $credentialsDetails = $credentials->fetchCredentials($userRef); 
            return response()->json(['status' => [
                                                    'code' => 200, 
                                                    'message' => 'obtained credentials data'
                                                 ],
                                                'data' => [
                                                    'credentials' => $credentialsDetails
                                            ]
                                        ]
                                    );

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }  
    }

    public function addCredentials(Request $request) {
        $userRef = Auth::user()->ref;

        try {
            if (!is_null($userRef)) {

                $permissionsIds = $request->permissions;

                if (!is_null($userRef) && !is_null($permissionsIds)) {
                    
                    $credentials = new Credentials(new CredentialsService());
                    $credentialsDetails = $credentials->addCredentials($userRef, $permissionsIds);

                    return response()->json(['status' => [
                                                            'code' => 200, 
                                                            'message' => 'added credentials'
                                                        ],
                                                        'data' => [
                                                            'credentials' => $credentialsDetails
                                                    ]
                                                ]
                                            );
                }
    
                throw new \Exception('Invalid permissions for credentials');
            }
           
            throw new \Exception('Invalid user ref');

        } catch (\Exception $e) {
            $message =  $e->getMessage();

            return response()->json(['status' => [
                                               'code' => 500, 
                                               'message' => $message
                                           ]
                                       ]);
        }
    }

    public function setCredentialStatus(Request $request) {
        try {
            $credentialRef = $request->route('credential_ref');
            $status = $request->status;
            $userRef = Auth::user()->ref;


            if (!is_null($credentialRef)) {

                if (!is_null($status)) {
                    $credentials = new Credentials(new CredentialsService());
                    $credentialActivateStatus = $credentials->setCredentialStatus($credentialRef, $status, $userRef);

                    return response()->json(['status' => [
                                                            'code' => 200, 
                                                            'message' => $credentialActivateStatus
                                                        ]
                                                ]
                                            );
                }

                throw new \Exception('Invalid credential status');

            }

            throw new \Exception('Invalid credential ref');
            
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
