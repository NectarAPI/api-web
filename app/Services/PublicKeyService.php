<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Http\Utils\UuidUtils;

class PublicKeyService {

    private $basicAuthUsername;
    private $basicAuthPassword;
    private $host;
    private $path;

    public function __construct() {
        $this->host = config('config-service.public-key-host');
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

    public function findByUserRef(String $userRef) {

        if (!is_null($userRef)) {
            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($this->   host, [
                                            'request_id' => UuidUtils::generate(),
                                            'user_ref' => $userRef
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

    public function setPublicKey(string $userRef, string $name, string $key, bool $activated) {

        if (!is_null($userRef) && !is_null($key) && !is_null($activated)) {

            $url = sprintf("%s?request_id=%s&user_ref=%s", $this->host,  UuidUtils::generate(), $userRef);

            $publicKey = array('name' => $name,
                            'public_key' => $key,
                            'activated' => $activated
                        );

            $client = new \GuzzleHttp\Client();
            $response = $client->post($url, [
                                            'headers' => ['Content-type' => 'application/json'],
                                            'auth' => [
                                                $this->basicAuthUsername, 
                                                $this->basicAuthPassword
                                            ],
                                            'json' => $publicKey,
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

    public function activatePublicKey(string $keyRef, string $userRef) {
        
        if (!is_null($keyRef)) {
            
            $url = sprintf("%s?request_id=%s&ref=%s&user_ref=%s", $this->host,  UuidUtils::generate(), $keyRef, $userRef);


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

    public function deactivatePublicKey(string $keyRef, string $userRef) {

        if (!is_null($keyRef)) {
            
            $url = sprintf("%s?request_id=%s&ref=%s&user_ref=%s", $this->host,  UuidUtils::generate(), $keyRef, $userRef);


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