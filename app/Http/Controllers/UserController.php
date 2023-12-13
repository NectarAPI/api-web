<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Services\UserService;
use App\Http\Controllers\Managers\AvatarManager;

class UserController extends Controller {

    private static $IMAGE_WIDTH = 200;

    public function __construct() {
        $this->middleware('auth');
    }

    public function getUser(Request $request) {
        $userRef = $request->user_ref;

        try {
            if (!is_null($userRef)) {

                if (Auth::user()->ref == $userRef) {
                    $user = new User(new UserService());
                    $userDetails = $user->fetchUserByRef($userRef);
                    return response()->json(['status' => [
                                                            'code' => 200, 
                                                            'message' => 'obtained user data'
                                                        ],
                                                            'data' => [
                                                                'user' => [
                                                                    "first_name" => $userDetails->firstName,
                                                                    "last_name" => $userDetails->lastName,
                                                                    "phone_no" => $userDetails->phoneNo,
                                                                    "email" => $userDetails->email,
                                                                    "image_url" => $userDetails->imageURL,
                                                                    "password" => $userDetails->password,
                                                                    "username" => $userDetails->username,
                                                                    'ref' => $userDetails->ref
                                                                ]
                                                            ]
                                                        ]
                                                    );
                } else {
                    throw new \Exception('Logged in user and search ref mismatch');
                }
            } 

            throw new \Exception(sprintf('Invalid user ref'));

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);
        }   
    }

    public function getActivityLog(Request $request) {
        try {
            $userRef = Auth::user()->ref;

            if (!is_null($userRef)) {
                $user = new User(new UserService());
                $userActivityLog = $user->getActivityLog($userRef);
                return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => 'obtained user activity log'
                                                    ],
                                                        'data' => $userActivityLog
                                                    ]
                                                );
            }

            throw new \Exception(sprintf('Invalid user ref'));

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);
        }  
    }

    public function updateUser(Request $request) {
        try {
            $this->validator($request->all())->validate();

            $userRef = Auth::user()->ref;

            if (!is_null($userRef)) {
    
                if (Auth::user()->ref == $userRef) {

                    $user = new User(new UserService());

                    $avatar = $request->file('image');
                    $fileName = '';

                    if(!is_null($avatar)) {
                        $avatarManager = new AvatarManager();
                        $fileName = $avatarManager->resizeAndUploadimageToS3($avatar, self::$IMAGE_WIDTH);
                    }

                    $requestId = $user->updateUser($request->user_ref, $request->first_name, $request->last_name, 
                                                    $request->phone_no, $fileName, $request->email, $request->password);

                    return response()->json(['status'   => 200, 
                                                'message' => 'successfully updated user',
                                                'request_id' => $requestId]);

                    } else {
                        throw new \Exception('Logged in user and update user ref mismatch');
                        
                    }
            } 
    
            throw new \Exception(sprintf('Invalid user ref'));

        } catch(\Exception $e){

            if ($e instanceof \Illuminate\Validation\ValidationException) {

               $errors = $e->errors();

               foreach ($errors as $key =>  $value) {
                    $arrImplode[] = implode( ', ', $errors[$key] );
                }

                $message = implode(', ', $arrImplode);
        
            } else {
                $message =  $e->getMessage();
            }
            
            return response()->json(['status' => 500, 'message' => $message]);

        }
    }

    private function validator(array $data) {
        
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'min:1', 'max:255'],
            'last_name' => ['required', 'string', 'min:1', 'max:255'],
            'phone_no' => ['required', 'regex:/^[0-9]*$/u'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['string', 'min:8', 'nullable'],
            'image_url' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:5120', 'nullable']
        ],
        [
            'first_name.required' => 'The :attribute is required',
            'first_name.string' => 'The :attribute cannot be greater than 255 characters',
            'first_name.min' => 'The :attribute cannot be less than 1 character',
            'first_name.max' => 'The :attribute cannot be greater than 255 characters',
            'last_name.required' => 'The :attribute field is required',
            'last_name.string' => 'The :attribute cannot be greater than 255 characters',
            'last_name.min' => 'The :attribute cannot be less than 1 character',
            'last_name.max' => 'The :attribute cannot be greater than 255 characters',
            'phone_no.required' => 'The :attribute field is required',
            'phone_no.regex' => 'The :attribute format is invalid',
            'email.required' => 'The :attribute field is required',
            'email.string' => 'The :attribute must be a string',
            'email.email' => 'The :attribute format is invalid',
            'email.max' => 'The :attribute cannot be more than 255 characters long',
            'password.string' => 'The :attribute must be a string',
            'password.min' => 'The :attribute must be 8 characters or greater',
            'image.image' => 'attribute: must be an image' ,
            'image.mimes' => 'attribute: supported types are jpeg, png, jpg, gif and svg',
            'image.max' => 'attribute: file size is 5MB'
        ]);
    }
    
}
