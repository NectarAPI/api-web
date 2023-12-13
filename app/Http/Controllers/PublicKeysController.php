<?php

namespace App\Http\Controllers;

use App\PublicKey;
use App\Services\PublicKeyService;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PublicKeysController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function getKeys (Request $request) {
        $userRef = Auth::user()->ref;

        try {
            $publicKey = new PublicKey(new PublicKeyService());
            $publicKeyDetails = $publicKey->fetchPublicKeys($userRef);
            return response()->json(['status' => [
                                                    'code' => 200, 
                                                    'message' => 'obtained public keys data'
                                                 ],
                                                'data' => [
                                                    'public_keys' => $publicKeyDetails
                                            ]
                                        ]
                                    );

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }   
    }

    public function setKey(Request $request) {
        $userRef = Auth::user()->ref;

        try {
            $this->validator($request->all())->validate();

            if (!is_null($userRef)) {

                $publicKey = new PublicKey(new PublicKeyService());

                $requestActivated = false;

                if ($request->activated == true || 
                        $request->activated == 'true' || 
                        $request->activated == 1) {
                    $requestActivated = true;
                }

                $addedPublicKey = $publicKey->setPublicKey($userRef, 
                                                            $request->name,
                                                            $request->key, 
                                                            $requestActivated);

                return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => 'added public key'
                                                     ],
                                                    'data' => [
                                                        'public_key' => $addedPublicKey
                                                ]
                                            ]
                                        );
            }

            throw new \Exception(sprintf('Invalid user ref'));

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

    public function activateDeactivateKey(Request $request) {
        $userRef = Auth::user()->ref;
        $keyRef = $request->key_ref;

        try {
            if (!is_null($keyRef)) { 

                $publicKey = new PublicKey(new PublicKeyService());
                $publicKeyDetails = $publicKey->fetchPublicKeys($userRef);
                
                foreach($publicKeyDetails as $pk) {

                    if ($pk['ref'] == $keyRef) {

                        if ($pk['activated']) {
                            $updatedPublicKey = $publicKey->deactivatePublicKey($keyRef, $userRef);

                        } else {
                            $updatedPublicKey = $publicKey->activatePublicKey($keyRef, $userRef);

                        }

                        $message = $pk['activated'] ? 'Deactivated public key' : 'Activated public key';

                        return response()->json(['status' => [
                                                                'code' => 200, 
                                                                'message' => $message
                                                            ],
                                                            'data' => [
                                                                'public_key' => $updatedPublicKey
                                                        ]
                                                    ]
                                                );
                    }
                }

                throw new \Exception(sprintf('Key ref %s not assigned to user', $keyRef));
            }

            throw new \Exception('Missing key ref');

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
            'key' => ['required', 'string', 'min:1', 'max:2000'],
            'activated' => Rule::in([true, false, 'true', 'false', 0, 1, '0', '1'])
        ],
        [
            'key.required' => 'The :attribute is required',
            'key.string' => 'The :attribute cannot be greater than 255 characters',
            'key.min' => 'The :attribute cannot be less than 1 character',
            'key.max' => 'The :attribute cannot be greater than 255 characters',
            'activate.boolean' => 'The :attribute must be either true or false'
        ]);
    }
}
