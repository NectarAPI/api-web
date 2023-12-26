<?php

namespace App;

use Carbon\Carbon;

use App\Services\UtilityService;

class Utility {

    private $service;

    public function __construct(UtilityService $service) {
        $this->service = $service;
    }

    public function activateUtility(string $utilityRef, string $userRef) {
        try {
            return $this->service->activateUtility($utilityRef, $userRef);

        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function deactivateUtility(string $utilityRef, string $userRef) {

        try {
            return $this->service->deactivateUtility($utilityRef, $userRef);

        } catch(\Exception $e) {
            throw $e;

        }
    }

}