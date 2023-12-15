<?php

namespace App;

use Carbon\Carbon;

use App\Services\UtilityService;

class Utility {

    private $service;

    public function __construct(UtilityService $service) {
        $this->service = $service;
    }

    public function getUtilities(string $userRef) {
        try {
            return $this->service->find(['user-ref' => $userRef]);
        } catch(\Exception $e) {
            throw $e;
        }
    }
}