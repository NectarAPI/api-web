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
        $this->host = config('subscribers-service.host');
        $this->basicAuthUsername = config('subscribers-service.username');
        $this->basicAuthPassword = config('subscribers-service.password');
    }

    public function find(array $criteria) {
        try {
            
            $username = $criteria['username'];
            return $this->findByUsername($username);   

        } catch(\Exception $e) {
            throw $e;
            
        }     
    }

    public function addSubscriber(string $userRef, string $name, string $contactPhoneNo, string $utility) {
        $url = sprintf("%s?request_id=%s&user_ref=%s", $this->host,  UuidUtils::generate(), $userRef);

        $subscriber = array ('name' => $name,
                            'phone_no' => $contactPhoneNo,
                            'activated' => True,
                            'utility' => $utility
                        );

        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, [
                                            'headers' => ['Content-type' => 'application/json'],
                                            'auth' => [
                                                $this->basicAuthUsername, 
                                                $this->basicAuthPassword
                                        ],
                                            'json' => $subscriber
                                    ]);
                                            
        $data = json_decode($response->getBody()->getContents(), true);

        if (!is_null($data)){
                        
            if ($data['status']['code'] != 200) {
                throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));
                    
            } else {
                return $data;
                    
            }
                
        } else {
            return $response->status();
                                        
        }
    }

}