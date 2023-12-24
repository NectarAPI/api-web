<?php

namespace App;

use Carbon\Carbon;

use App\Services\UtilityService;

class Utility {

    private $service;

    public function __construct(UtilityService $service) {
        $this->service = $service;
    }


}