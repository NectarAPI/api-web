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

    public function createMeter(string $userRef, string $meterNo, 
                                string $utility, string $type, 
                                string $subscriber = null) {
        try {
            return $this->service->createMeter($userRef, $meterNo, 
                                                $utility, $type, $subscriber);

        } catch(\Exception $e) {
            throw $e;
            
        }
    }

    public function updateMeter(string $meterRef, string $userRef, string $meterNo, 
                                string $utility, string $type, string $subscriber = null,
                                $activated) {
        try {
            return $this->service->updateMeter($meterRef, $userRef, $meterNo, 
                                                $utility, $type, $subscriber,
                                                $activated);

        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function activateMeter(string $meterRef, string $userRef) {
        try {
            return $this->service->activateMeter($meterRef, $userRef);

        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function deactivateMeter(string $meterRef, string $userRef) {

        try {
            return $this->service->deactivateMeter($meterRef, $userRef);

        } catch(\Exception $e) {
            throw $e;

        }
    }



}