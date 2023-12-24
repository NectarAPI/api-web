<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

use App\Http\Utils\UuidUtils;

class UtilityService {

    public function __construct() {
        $this->host = config('utility-service.host');
        $this->basicAuthUsername = config('utility-service.username');
        $this->basicAuthPassword = config('utility-service.password');
    }

    public function find(array $criteria) {
        try {
            $userRef = $criteria['user-ref'];
            return $this->findByUserRef($userRef);

        } catch(\Exception $e) {
            throw $e;
        }
    }


}