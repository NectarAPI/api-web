<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Services\Contracts\ServiceInterface;
use App\Http\Utils\UuidUtils;

class MeterService implements ServiceInterface {

    private $basicAuthUsername;
    private $basicAuthPassword;
    private $host;
    private $path;

    public function __construct() {
        $this->host = config('meter-service.host');
        $this->userServiceHost = config('user-service.host');
        $this->basicAuthUsername = config('meter-service.username');
        $this->basicAuthPassword = config('meter-service.password');
    }

    public function find(array $criteria) {
        try {
            
            $ref = $criteria['ref'];
            return $this->findByRef($ref);   

        } catch(\Exception $e) {
            throw $e;
            
        }     
    }

    public function getMeterTypes() {
        $url = sprintf("%s/types?request_id=%s", $this->host, UuidUtils::generate());

        $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($url);

        $data = $response->json();

        if ($response->successful() && !is_null($data)) {
                
            if ($data['status']['code'] == 200) {
                return $data['data']['meter_types'];

            } else {
                throw new \Exception(sprintf('Returned data for %s %s. %s', $param, $data['status']['code'], $data['status']['message']));

            }

        } else {
            return $response->status();

        }
    }

    public function getSubscribers(string $userRef) {

        if (!is_null($userRef)) {
            $host = sprintf("%s/%s/subscribers?request_id=%s", 
                            $this->userServiceHost, $userRef, UuidUtils::generate());

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($host);

            $data = $response->json();

            if ($response->successful() && !is_null($data)) {
                
                if ($data['status']['code'] == 200) {
                    return $data['data'];

                } else {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));

                }

            } else {
                return $response->status();
            }
        
        }  
    }

    public function createMeter($userRef, $meterNo, $utility, $type, $subscriber = null) {
        $url = sprintf("%s?request_id=%s&user_ref=%s", $this->host,  UuidUtils::generate(), $userRef);

        $meter = array ('no' => $meterNo,
                            'meter_type' => $type,
                            'utility_ref' => $utility,
                            'subscriber_ref' => $subscriber,
                            'activated' => True,
                        );

        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, [
                                            'headers' => ['Content-type' => 'application/json'],
                                            'auth' => [
                                                $this->basicAuthUsername, 
                                                $this->basicAuthPassword
                                        ],
                                            'json' => $meter
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

    public function updateMeter($meterRef, $userRef, $meterNo, $utility, $type, 
                                $subscriber = null, $activated) {
        $url = sprintf("%s?request_id=%s&user_ref=%s&meter_ref=%s", 
                        $this->host,  UuidUtils::generate(), $userRef, $meterRef);

        $meter = array ('no' => $meterNo,
                            'meter_type' => $type,
                            'utility_ref' => $utility,
                            'subscriber_ref' => $subscriber,
                            'activated' => $activated,
                        );

        $client = new \GuzzleHttp\Client();
        $response = $client->put($url, [
                                            'headers' => ['Content-type' => 'application/json'],
                                            'auth' => [
                                                $this->basicAuthUsername, 
                                                $this->basicAuthPassword
                                        ],
                                            'json' => $meter
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

    public function activateMeter(string $meterRef, string $userRef) {
        
        if (!is_null($meterRef)) {
            
            $url = sprintf("%s/%s?request_id=%s&user_ref=%s", $this->host, $meterRef, UuidUtils::generate(), $userRef);

            $client = new \GuzzleHttp\Client();
            $response = $client->put($url, [
                                            'headers' => ['Content-type' => 'application/json'],
                                            'auth' => [
                                                $this->basicAuthUsername, 
                                                $this->basicAuthPassword
                                            ]
                                        ]);
                                            
            $data = json_decode($response->getBody()->getContents(), true);

            if (!is_null($data)){
                        
                if ($data['status']['code'] != 200) {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));
                    
                } else {
                    return $data['status']['message'];
                    
                }
                    
            } else {
                return $response->status();
                                        
            }
        }
    }

    public function deactivateMeter(string $meterRef, string $userRef) {

        if (!is_null($meterRef)) {
            
            $url = sprintf("%s/%s?request_id=%s&user_ref=%s", $this->host, $meterRef, UuidUtils::generate(), $userRef);

            $client = new \GuzzleHttp\Client();
            $response = $client->delete($url, [
                                            'headers' => ['Content-type' => 'application/json'],
                                            'auth' => [
                                                $this->basicAuthUsername, 
                                                $this->basicAuthPassword
                                            ]
                                        ]);
                                            
            $data = json_decode($response->getBody()->getContents(), true);

            if (!is_null($data)){
                        
                if ($data['status']['code'] != 200) {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));
                    
                } else {
                    return $data['status']['message'];
                    
                }
                    
            } else {
                return $response->status();
                                        
            }
        }
    }

}