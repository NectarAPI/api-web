<?php

namespace App;

use Carbon\Carbon;

use App\Services\SubscriberMeterService;

class SubscriberMeter
{

    private $service;

    public function __construct(SubscriberMeterService $service) {
        $this->service = $service;
    }

    public function fetchSTSConfigurations(string $userRef) {
        try {
            return $this->service->find(['user-ref' => $userRef]);

        } catch(\Exception $e) {
            throw $e;

        }
    }


}