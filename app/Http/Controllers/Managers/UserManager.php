<?php

namespace App\Http\Controllers\Managers;

use App\Services\UserService;


class UserManager {

    public function getUserLastLogin (string $userRef) {
        $userService = new UserService();
        $activityLogs = $userService->getActivityLog($userRef);

        $escapedFirstRecord = false;

        foreach ($activityLogs as $activityLog) {
            if ($activityLog['category']['name'] == 'LOGIN') {
                if (!$escapedFirstRecord) {
                    $escapedFirstRecord = true;
                    continue;
                }
                return $activityLog;
            }
        }
    }
}