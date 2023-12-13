<?php

namespace App\Http\Controllers\Managers;

use App\Services\NotificationsService;


class NotificationsManager {

    public function getUserNotifications (string $userRef) {
        $criteria = array(
                'user-ref' => $userRef,
                'offset' => 0,
                'limit' => -1
        );
        $notificationsService = new NotificationsService();
        return $notificationsService->fetchNotifications($criteria);
    }

}