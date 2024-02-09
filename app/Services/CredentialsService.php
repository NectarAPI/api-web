<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Http\Utils\UuidUtils;

class CredentialsService {

    private $basicAuthUsername;
    private $basicAuthPassword;
    private $host;
    private $path;

    public function __construct() {
        $this->host = config('credentials-service.credentials-host');
        $this->permissionsHost = config('credentials-service.permissions-host');
        $this->basicAuthUsername = config('credentials-service.username');
        $this->basicAuthPassword = config('credentials-service.password');
    }

    public function find(array $criteria) {
        try {
            $userRef = $criteria['user-ref'];
            return $this->findByUserRef($userRef);    

        } catch(\Exception $e) {
            throw $e;
            
        }    
    }

    public function getPermissions() {
        $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($this->permissionsHost, [
                                            'request_id' => UuidUtils::generate(),
                                         ]);

        $data = $response->json();

        if ($response->successful() && !is_null($data)) {
            if ($data['status']['code'] == 200) {
                return $data['data']['permissions'];
                             
            } else {
                throw new \Exception(sprintf('Credentials service returned status %s. %s', $data['status']['code'], $data['status']['message']));
            }
                             
        } else {
            return $response->status();
        }                        
    }

    public function addCredentials(string $userRef, array $permissionsIds) {

        if (!is_null($userRef) && !is_null($permissionsIds)) {

            $url = sprintf("%s?request_id=%s&user_ref=%s", $this->host,  UuidUtils::generate(), $userRef);

            $client = new \GuzzleHttp\Client();
            $response = $client->post($url, [
                                            'headers' => ['Content-type' => 'application/json'],
                                            'auth' => [
                                                $this->basicAuthUsername, 
                                                $this->basicAuthPassword
                                            ],
                                            'json' => $permissionsIds,
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

    public function findByUserRef(String $userRef) {

        if (!is_null($userRef)) {
            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($this->host, [
                                            'request_id' => UuidUtils::generate(),
                                            'user_ref' => $userRef
                                         ]);

            $data = $response->json();

            if ($response->successful() && !is_null($data)) {
                if ($data['status']['code'] == 200) {
                    return $data['data']['data'];

                } else {
                    throw new \Exception(sprintf('Credentials service returned status %s. %s', $data['status']['code'], $data['status']['message']));
                }

            } else {
                return $response->status();
            }
        }
    }

    public function setCredentialStatus(string $credentialRef, string $status, string $userRef) {
        if (!is_null($credentialRef) && !is_null($status)) {

            $url = sprintf("%s?request_id=%s&ref=%s&user_ref=%s", $this->host,  
                                                            UuidUtils::generate(),
                                                            $credentialRef,
                                                            $userRef);

            $client = new \GuzzleHttp\Client();

            if ($status == 'true') {
                $response = $client->delete($url, [
                                                'headers' => ['Content-type' => 'application/json'],
                                                'auth' => [
                                                    $this->basicAuthUsername, 
                                                    $this->basicAuthPassword
                                                ]
                                            ]);
            } else {

                $response = $client->put($url, [
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