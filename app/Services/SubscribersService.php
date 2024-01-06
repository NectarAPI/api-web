<?php

namespace App\Services;

use App\User;
use App\Utility;

use App\Services\UserService;
use App\Services\UtilityService;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Services\Contracts\ServiceInterface;
use App\Http\Utils\UuidUtils;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SubscribersService implements ServiceInterface {

    private $basicAuthUsername;
    private $basicAuthPassword;
    private $host;
    private $path;

    public function __construct() {
        $this->host = config('subscriber-service.host');
        $this->utilitiesHost = config('user-service.host');
        $this->basicAuthUsername = config('subscriber-service.username');
        $this->basicAuthPassword = config('subscriber-service.password');
    }

    public function find(array $criteria) {
        try {
            
            $username = $criteria['username'];
            return $this->findByUsername($username);   

        } catch(\Exception $e) {
            throw $e;
            
        }     
    }

}