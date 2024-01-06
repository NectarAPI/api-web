<?php

namespace App;

use Carbon\Carbon;

use App\Services\SubscribersService;

class Subscriber {

    private $service;

    public function __construct(SubscribersService $subscribersService) {
        $this->service = $service;
    }

    public function getSubscribers(string $userRef) {
        try {
            return $this->service->getSubscribers(['user-ref' => $userRef]);
            
        } catch(\Exception $e) {
            throw $e;

        }
    }
}