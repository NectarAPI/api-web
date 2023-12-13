<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Services\UserService;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function userServiceLogin(Request $request) {

        try {
            $this->validator($request->all())->validate();

            $remember  = (!empty( $request->remember_me )) ? true : false;

            if(Auth::attempt(['username' => $request->username, 
                                'password' => $request->password], $remember)){ 

                $user = Auth::user();
                $username = $user->username;

                Auth::login($user, $remember);

                $updateUser = new User(new UserService());
                $loginActivityLogRef = $updateUser->setLoginUserActivityLog($user->ref);

                return response()->json(['status'   => 200, 
                                            'message' => sprintf('Successfully authenticated user. [Ref: %s]', $loginActivityLogRef),
                                            'user' => $username,]);

            } else { 
                return response()->json(['status' => 500, 'message' => 'Unauthorized Access. Please check login credentials.']); 
                
            } 
          
        } catch(\Exception $e){
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);

        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'min:1', 'max:255'],
            'password' => ['required', 'string', 'min:6']
        ],
        [
            'username.required' => 'The :attribute is required.',
            'username.string' => 'The :attribute cannot be greater than 255 characters.',
            'username.min' => 'The :attribute cannot be less than 1 character.',
            'username.max' => 'The :attribute cannot be greater than 255 characters.',
            'password.required' => 'A password is required.',
            'password.string' => 'The :attribute must be a string',
            'password.min' => 'The :attribute must be 8 characters or greater'
        ]);
    }
}
