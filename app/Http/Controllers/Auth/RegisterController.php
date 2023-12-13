<?php

namespace App\Http\Controllers\Auth;

use App\Credits;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Managers\AvatarManager;
use App\Http\Controllers\Managers\MailManager;
use App\User;
use App\Services\UserService;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
   
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';

    private const IMAGE_WIDTH = 192;

    private $createdUserRef = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm() {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $this->validator($request->all())->validate();

            $this->create($request->all());

            $userKey = Hash::make($this->createdUserRef . env('VERIFY_EMAIL_OBFUSCATE'));

            $mailManager = new MailManager();
            $mailManager->sendWelcomeEmail(sprintf('%s %s', $request->first_name, $request->last_name),
                                            $request->email, 
                                            $userKey);
            
            return response()->json(['status'   => 200, 
                                        'message' => 'successfully registered user',
                                        'user_ref' => $this->createdUserRef]);

        } catch(\Exception $e){
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);

        }
    }

    protected function create(array $data)
    {  
        $request = app('request');
        $fileName = '';
        $avatar = $request->file('image');

        $firstName = $request->first_name;
        $lastName = $request->last_name;
        $username = $request->username;
        $phoneNo = $request->phone_no;
        $email = $request->email;
        $password = $request->password;

        if(!is_null($avatar)) {
            $avatarManager = new AvatarManager();
            $fileName = $avatarManager->resizeAndUploadimageToS3($avatar, self::IMAGE_WIDTH);
        }

        $user = new User(new UserService());
        $this->createdUserRef = $user->createUser($firstName, $lastName, $username, 
                                                    $phoneNo, $fileName, $email, $password);

        return $user;
    }

    private function validator(array $data) {
        
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'min:1', 'max:255'],
            'last_name' => ['required', 'string', 'min:1', 'max:255'],
            'username' => ['required', 'string', 'min:1', 'max:255'],
            'phone_no' => ['required', 'regex:/^[0-9]*$/u'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'image_url' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:5120']
        ],
        [
            'first_name.required' => 'The :attribute is required.',
            'first_name.string' => 'The :attribute cannot be greater than 255 characters.',
            'first_name.min' => 'The :attribute cannot be less than 1 character.',
            'first_name.max' => 'The :attribute cannot be greater than 255 characters.',
            'last_name.required' => 'The :attribute field is required.',
            'last_name.string' => 'The :attribute cannot be greater than 255 characters.',
            'last_name.min' => 'The :attribute cannot be less than 1 character.',
            'last_name.max' => 'The :attribute cannot be greater than 255 characters.',
            'username.required' => 'The :attribute field is required.',
            'username.string' => 'The :attribute cannot be greater than 255 characters.',
            'username.min' => 'The :attribute cannot be less than 1 character.',
            'username.max' => 'The :attribute cannot be greater than 255 characters.',
            'phone_no.required' => 'The :attribute field is required.',
            'phone_no.regex' => 'The :attribute format is invalid.',
            'email.required' => 'The :attribute field is required.',
            'email.string' => 'The :attribute must be a string',
            'email.email' => 'The :attribute format is invalid.',
            'email.max' => 'The :attribute cannot be more than 255 characters long',
            'password.required' => 'A password is required.',
            'password.string' => 'The :attribute must be a string',
            'password.min' => 'The :attribute must be 8 characters or greater',
            'image.image' => 'attribute: must be an image' ,
            'image.mimes' => 'attribute: supported types are jpeg, png, jpg, gif and svg',
            'image.max' => 'attribute: file size is 5MB'
        ]);
    }
}
