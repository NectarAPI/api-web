<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Http\Utils\UuidUtils;

class SubscriberMeterService {

    private $basicAuthUsername;
    private $basicAuthPassword;
    private $host;
    private $path;

    public function __construct() {
        $this->host = config('subscriber-meter-service.public-key-host');
        $this->basicAuthUsername = config('config-service.username');
        $this->basicAuthPassword = config('config-service.password');
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