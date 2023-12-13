<?php

namespace App;

use Carbon\Carbon;

use App\Services\NotificationsService;

class Notifications {

    private $service;

    public function __construct(NotificationsService $service) {
        $this->service = $service;
    }

    public function fetchNotifications(string $userRef, int $offset = null, int $limit = null) {
        try {
            return $this->service->fetchNotifications(['user-ref' => $userRef,
                                                        'offset' => $offset,
                                                        'limit' => $limit]);

        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function setReadNotifications(string $userRef, array $notificationsRefs) {
        try {
            return $this->service->setReadNotifications($userRef, $notificationsRefs);

        } catch(\Exception $e) {
            throw $e;
        }
    }

}