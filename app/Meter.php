<?php

namespace App;

use Carbon\Carbon;

use App\Services\MeterService;

class Meter {

    private $service;

    public function __construct(MeterService $service) {
        $this->service = $service;
    }

    public function getMeterTypes() {
        try {
            return $this->service->getMeterTypes();

        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function getSubscribers(string $userRef) {
        try {
            return $this->service->getSubscribers($userRef);
            
        } catch(\Exception $e) {
            throw $e;
            
        }
    }

}