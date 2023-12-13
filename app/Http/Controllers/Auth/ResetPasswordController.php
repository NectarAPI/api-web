<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Services\UserService;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function showResetPasswordForm(Request $request) {
        try {
            $email = $request->email;
            $userKey = $request->user_key;

            if (!is_null($email) && !is_null($userKey)) {
                $user = new User(new UserService());
                $userDetails = $user->fetchByEmail($email);

                if (!is_null($userDetails)) {

                    if (Hash::check($userDetails->ref . env('VERIFY_FORGOT_PASSWORD_OBFUSCATE'), $userKey)) {
                        return view('auth.reset', ['emailFound' => true, 'email' => $email, 'userKey' => $userKey]);

                    }
                }
            } 
            
            return view('auth.reset', ['emailFound' => false, 'email' => $email, 'error' => 'Null email or user key']);

        } catch(\Exception $e) {
            return view('auth.reset', ['emailFound' => false, 'error' => $e->getMessage()]);

        }
    }

    public function resetPassword(Request $request) {
        try {
            $email = $request->email;
            $password = $request->password;
            $confirmPassword = $request->password_confirmation;
            $userKey = $request->user_key;

            if (!is_null($email) && !is_null($userKey)) {
                $user = new User(new UserService());
                $userDetails = $user->fetchByEmail($email);

                if (!is_null($userDetails)) {
                    if (Hash::check($userDetails->ref . env('VERIFY_FORGOT_PASSWORD_OBFUSCATE'), $userKey)) {

                        $this->validator($request->all())->validate();

                        $user->updatePassword($userDetails, $password);

                        return response()->json(['status'   => 200, 
                                                'message' => sprintf('successfully reset user password. username: %s', $userDetails->username) ,
                                                'user_ref' => $userDetails->ref]);

                    }
                }
            } 
            
            return response()->json(['status' => 500, 'message' => sprintf('Invalid email %s', $email)]);

        } catch(\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);

        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ],
        [
            'password.required' => 'A password is required.',
            'password.string' => 'The :attribute must be a string',
            'password.min' => 'The :attribute must be 8 characters or greater',
            'password.confirmed' => 'The password and confirmed password do not match.'
        ]);
    }
}
