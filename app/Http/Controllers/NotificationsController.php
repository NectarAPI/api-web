<?php

namespace App\Http\Controllers;

use App\Notifications;
use App\Services\NotificationsService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getNotifications(Request $request) {
        try {
            $userRef = Auth::user()->ref;

            if (!is_null($userRef)) {
                $offset = $request->offset;
                $limit = $request->limit;

                $notifications = new Notifications(new NotificationsService());
                $notificationsDetails = $notifications->fetchNotifications($userRef, $offset, $limit);

                return response()->json(['status' => [
                        'code' => 200, 
                        'message' => 'obtained user notifications'
                    ],
                        'data' => [
                            'notifications' => $notificationsDetails
                        ]
                    ]
                );
            }

            throw new \Exception('Missing user ref');

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);
        }
    }

    public function setReadNotifications(Request $request) {
        try {
            $userRef = Auth::user()->ref;

            if (!is_null($userRef)) {
                $notificationsRefs = $request->notifications;

                if (is_array($notificationsRefs) && count($notificationsRefs) > 0) {

                    $notifications = new Notifications(new NotificationsService());
                    $response = $notifications->setReadNotifications($userRef, $notificationsRefs);

                    return response()->json(['status' => [
                                'code' => 200, 
                                'message' => 'set notifications read status'
                            ]
                        ]
                    );
                } else {
                    throw new \Exception('None or invalid notifications provided');

                }
            }

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);
        }
    }
}
