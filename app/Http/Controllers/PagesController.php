<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Services\UserService;

use App\Http\Controllers\Managers\NotificationsManager;
use App\Http\Controllers\Managers\UserManager;

class PagesController extends Controller {   

    private $user;
    private $notifications;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            try {
                if (Auth::check()) {
                    $this->user = Auth::user();
                    $notificationsManager = new NotificationsManager();
                    $this->notifications = $notificationsManager->getUserNotifications($this->user->ref);
                } else {
                    return redirect()->route('login');
                }

            } catch (\Exception $e) {
                info($e->getMessage());
                return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);
            }    

            return $next($request);
        });
    }

    public function dashboard(Request $request) {
        $userManager = new UserManager();

        return view('dashboard', [
            'user' => $this->user,
            'notifications' => $this->notifications,
            'lastLoginDate' => $userManager->getUserLastLogin($this->user->ref)['created_at']
        ]);
    }

    public function utilities(Request $request) {
        $userManager = new UserManager();

        return view('utilities', [
            'user' => $this->user,
            'notifications' => $this->notifications,
            'lastLoginDate' => $userManager->getUserLastLogin($this->user->ref)['created_at']
        ]);
    }

    public function meters(Request $request) {
        $userManager = new UserManager();

        return view('meters', [
            'user' => $this->user,
            'notifications' => $this->notifications,
            'lastLoginDate' => $userManager->getUserLastLogin($this->user->ref)['created_at']
        ]);
    }

    public function subscribers(Request $request) {
        $userManager = new UserManager();

        return view('subscribers', [
            'user' => $this->user,
            'notifications' => $this->notifications,
            'lastLoginDate' => $userManager->getUserLastLogin($this->user->ref)['created_at']
        ]);
    }


    public function requests(Request $request) {
        return view('requests', [
            'user' => $this->user,
            'notifications' => $this->notifications
        ]);
    }

    public function credentials(Request $request) {
        return view('credentials', [
            'user' => $this->user,
            'notifications' => $this->notifications
        ]);
    }

    public function publicKeys(Request $request) {
        return view('public-keys', [
            'user' => $this->user,
            'notifications' => $this->notifications
        ]);
    }

    public function configurations(Request $request) {
        return view('configurations', [
            'user' => $this->user,
            'notifications' => $this->notifications
        ]);
    }

    public function credits(Request $request) {
        return view ('credits', [
            'user' => $this->user,
            'notifications' => $this->notifications
        ]);
    }

    public function notifications(Request $request) {
        return view('notifications', [
            'user' => $this->user,
            'notifications' => $this->notifications
        ]);
    }
    
    public function profile(Request $request) {
        return view('profile', [
            'user' => $this->user,
            'notifications' => $this->notifications
        ]);
    }

    public function simulators(Request $request) {
        return view('simulators', [
            'user' => $this->user,
            'notifications' => $this->notifications
        ]);
    }

    public function termsAndConditions(Request $request) {
        return view('terms_and_conditions', [
            'user' => $this->user,
            'notifications' => $this->notifications
        ]);
    }

    public function privacyPolicy(Request $request) {
        return view('privacy_policy', [
            'user' => $this->user,
            'notifications' => $this->notifications
        ]);
    }

}
