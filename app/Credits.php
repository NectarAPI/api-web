<?php

namespace App;

use Carbon\Carbon;

use App\Services\CreditsService;

class Credits
{

    private $service;

    public function __construct(CreditsService $service) {
        $this->service = $service;
    }

    public function getAggregate(string $userRef, $param) {
        try {
            return $this->service->getAggregate($userRef, $param);
            
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function getTimelineCreditsCreditsConsumption(string $userRef, int $months) {
        try {
            return $this->service->getTimelineCreditsCreditsConsumption(['user-ref' => $userRef, 'months' => $months]);

        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function getCreditsConsumption(string $userRef) {
        try {
            return $this->service->getCreditsConsumption(['user-ref' => $userRef]);

        } catch(\Exception $e) {
            throw $e;

        }
    }

}