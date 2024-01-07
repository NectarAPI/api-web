<?php

namespace App;

use Carbon\Carbon;

use App\Services\SubscribersService;

class Subscriber {

    private $service;

    public function __construct(SubscribersService $service) {
        $this->service = $service;
    }

    public function getSubscribers(string $userRef) {
        try {
            return $this->service->getSubscribers(['user-ref' => $userRef]);
            
        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function addSubscriber(string $userRef, string $name, string $phoneNo, string $utility) {
        try {
            return $this->service->addSubscriber($userRef, $name, $phoneNo, $utility);

        } catch(\Exception $e) {
            throw $e;

        }
    }
}