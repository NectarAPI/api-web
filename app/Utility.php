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

    public function addUtility($userRef, $name, $contactPhoneNo, 
                                    $unitCharge, $configRef) {
        try {
            return $this->service->addUtility($userRef, $name, $contactPhoneNo, 
                                                    $unitCharge, $configRef);
                                
        } catch(\Exception $e) {
            throw $e;
                                
        }
    }

    public function updateUtility($userRef, $utilityRef, $name, $contactPhoneNo, 
                                    $unitCharge, $configRef, $activated) {
        try {
            return $this->service->updateUtility($userRef, $utilityRef, $name, $contactPhoneNo, 
                                                    $unitCharge, $configRef, $activated);

        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function getMeters($utilityRef) {
        try {
            return $this->service->getMeters($utilityRef);
            
        } catch(\Exception $e) {
            throw $e;

        }
    }

}