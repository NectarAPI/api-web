<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use App\User;
use App\Services\UserService;
use App\Http\Controllers\Managers\MailManager;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function verify(Request $request)
    {
        try {
            $email = $request->email;
            $userKey = $request->user_key;

            if (!is_null($email) && !is_null($userKey)) {
                $user = new User(new UserService());
                $userDetails = $user->fetchByEmail($email);

                if (!is_null($userDetails)) {
                    if (Hash::check($userDetails->ref . env('VERIFY_EMAIL_OBFUSCATE'), $userKey)) {
                        $user->updateEmailVerifiedAt($user, Carbon::now());
                        return view('auth.verified', ['verified' => true]);

                    }
                }
            } 
            
            return view('auth.verified', ['verified' => false]);

        } catch(\Exception $e) {
            return view('auth.error-verified', ['verified' => false, 'error' => $e->getMessage()]);

        }
    }

    public function showForgotPasswordForm(Request $request)
    {
        return view('auth.forgot-password');
    }

    public function generateResetPasswordEmailLink(Request $request) {
        try {
            $email = $request->email;

            if (!is_null($email)) {
                $user = new User(new UserService());
                $userDetails = $user->fetchByEmail($email);

                if (!is_null($userDetails)) {
                    
                    $userKey = Hash::make($userDetails->ref . env('VERIFY_FORGOT_PASSWORD_OBFUSCATE'));

                    $mailManager = new MailManager();
                    $mailManager->sendResetPasswordEmail(sprintf('%s %s', $userDetails->firstName, $userDetails->lastName),
                                                            $userDetails->email, 
                                                            $userKey);
                    
                    return response()->json(['status'   => 200, 
                                                'message' => 'successfully sent reset password email',
                                                'user_ref' => $userDetails->ref]);
                                                
                } else {
                    return response()->json(['status' => 500, 'message' => sprintf('Invalid email %s', $email)]);
                    
                }
            } 
            
        } catch(\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);

        }
    }

}