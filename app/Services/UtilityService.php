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

    public function activateUtility(string $utilityRef, string $userRef) {
        
        if (!is_null($utilityRef)) {
            
            $url = sprintf("%s/%s?request_id=%s&user_ref=%s", $this->host, $utilityRef, UuidUtils::generate(), $userRef);

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

    public function deactivateUtility(string $utilityRef, string $userRef) {

        if (!is_null($utilityRef)) {
            
            $url = sprintf("%s/%s?request_id=%s&user_ref=%s", $this->host, $utilityRef, UuidUtils::generate(), $userRef);

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

    public function addUtility($userRef, $name, $contactPhoneNo, $unitCharge, $configRef, $activated=true) {
        $url = sprintf("%s?request_id=%s&user_ref=%s", $this->host,  UuidUtils::generate(), $userRef);

        $utility = array ('name' => $name,
                            'contact_phone_no' => $contactPhoneNo,
                            'unit_charge' => $unitCharge,
                            'activated' => $activated,
                            'config_ref' => $configRef,
                            'activated' => True
                        );

        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, [
                                            'headers' => ['Content-type' => 'application/json'],
                                            'auth' => [
                                                $this->basicAuthUsername, 
                                                $this->basicAuthPassword
                                        ],
                                            'json' => $utility
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

    public function updateUtility($userRef, $utilityRef, $name, $contactPhoneNo, $unitCharge, $configRef, $activated) {

        if (!is_null($utilityRef)) {
            
            $url = sprintf("%s?request_id=%s&ref=%s&user_ref=%s", $this->host,  UuidUtils::generate(), $utilityRef, $userRef);

            $utility = array ('name' => $name,
                            'ref' => $utilityRef,
                            'contact_phone_no' => $contactPhoneNo,
                            'unit_charge' => $unitCharge,
                            'activated' => $activated,
                            'config_ref' => $configRef
                        );

            $client = new \GuzzleHttp\Client();
            $response = $client->put($url, [
                                            'headers' => ['Content-type' => 'application/json'],
                                            'auth' => [
                                                $this->basicAuthUsername, 
                                                $this->basicAuthPassword
                                            ],
                                            'json' => $utility
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

    public function getMeters($utilityRef) {
        if (!is_null($utilityRef)) {

            $url = sprintf("%s/%s/meter?request_id=%s", $this->host, $utilityRef, UuidUtils::generate());

            $client = new \GuzzleHttp\Client();
            $response = $client->get($url, [
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
                    return $data['data'];
                    
                }
                    
            } else {
                return $response->status();
                                        
            }
        }
    }

}