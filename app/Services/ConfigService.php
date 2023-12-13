<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Http\Utils\UuidUtils;

class ConfigService {

    private $basicAuthUsername;
    private $basicAuthPassword;
    private $host;
    private $path;

    public function __construct() {
        $this->host = config('config-service.config-host');
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

    public function findByUserRef(string $userRef) {

        if (!is_null($userRef)) {
            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($this->host, [
                                            'request_id' => UuidUtils::generate(),
                                            'user_ref' => $userRef,
                                            'detailed' => true
                                         ]);

            $data = $response->json();

            if ($response->successful() && !is_null($data)) {
                if ($data['status']['code'] == 200) {
                    return $data['data']['data'];

                } else {
                    throw new \Exception(sprintf('Config service returned status %s. %s', $data['status']['code'], $data['status']['message']));
                }

            } else {
                return $response->status();
            }
        }
    }

    public function findByRef(string $userRef, string $ref, bool $detailed) {
        if (!is_null($userRef)) {
            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($this->host, [
                                            'request_id' => UuidUtils::generate(),
                                            'user_ref' => $userRef,
                                            'ref' => $ref,
                                            'detailed' => $detailed
                                         ]);

            $data = $response->json();

            if ($response->successful() && !is_null($data)) {
                if ($data['status']['code'] == 200) {
                    return $data['data']['data'];

                } else {
                    throw new \Exception(sprintf('Config service returned status %s. %s', $data['status']['code'], $data['status']['message']));
                }

            } else {
                return $response->status();
            }
        }
    }

    public function addSTSConfigurations(string $userRef, string $data, 
                                        string $digest, string $key) {
        if (!is_null($userRef) && !is_null($data) 
                && !is_null($digest) && !is_null($key)) {

            $url = sprintf("%s?request_id=%s&user_ref=%s", $this->host,  
                                                            UuidUtils::generate(),
                                                            $userRef);

            $stsConfig = array('data' => $data,
                                'digest' => $digest,
                                'key' => $key
                                );
        
            $client = new \GuzzleHttp\Client();
            $response = $client->post($url, [
                                                'headers' => ['Content-type' => 'application/json'],
                                                'auth' => [
                                                    $this->basicAuthUsername, 
                                                    $this->basicAuthPassword
                                                ],
                                                'json' => $stsConfig,
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

    public function setConfigStatus(string $configRef, string $status, string $userRef) {
        if (!is_null($configRef) && !is_null($status)) {

            $url = sprintf("%s?request_id=%s&config_ref=%s&user_ref=%s", $this->host,  
                                                            UuidUtils::generate(),
                                                            $configRef,
                                                            $userRef);

            $client = new \GuzzleHttp\Client();

            if ($status == 'true') {
                $response = $client->put($url, [
                                                'headers' => ['Content-type' => 'application/json'],
                                                'auth' => [
                                                    $this->basicAuthUsername, 
                                                    $this->basicAuthPassword
                                                ]
                                            ]);
            } else {

                $response = $client->delete($url, [
                                                    'headers' => ['Content-type' => 'application/json'],
                                                    'auth' => [
                                                        $this->basicAuthUsername, 
                                                        $this->basicAuthPassword
                                                    ]
                                                ]);
            }

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