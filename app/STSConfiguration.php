<?php

namespace App;

use Carbon\Carbon;

use App\Services\ConfigService;

class STSConfiguration
{

    private $service;

    public function __construct(ConfigService $service) {
        $this->service = $service;
    }

    public function fetchSTSConfigurations(string $userRef) {
        try {
            return $this->service->find(['user-ref' => $userRef]);

        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function addSTSConfigurations(string $userRef, string $data, 
                                        string $digest, string $key) {
        try {
            return $this->service->addSTSConfigurations($userRef, $data, $digest, $key);
            
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function setConfigStatus(string $configRef, string $status, string $userRef) {
        try {
            return $this->service->setConfigStatus($configRef, $status, $userRef);
            
        } catch (\Exception $e) {
            throw $e;
        }
    }

}