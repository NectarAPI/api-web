<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Services\Contracts\ServiceInterface;
use App\Http\Utils\UuidUtils;
use App\Services\ConfigService;

class TokensService implements ServiceInterface {

    private $basicAuthUsername;
    private $basicAuthPassword;
    private $host;
    private $path;

    public function __construct() {
        $this->host = config('tokens-service.host');
        $this->basicAuthUsername = config('tokens-service.username');
        $this->basicAuthPassword = config('tokens-service.password');
    }

    public function find(array $criteria) {
        try {
            
            $ref = $criteria['ref'];
            $weeks = $criteria['weeks'];
            return $this->findByRef($ref, $weeks);   

        } catch(\Exception $e) {
            throw $e;
            
        }     
    }

    public function findByRef(string $ref, int $weeks) {
        if (!is_null($ref)) {

            $host = sprintf("%s?ref=%s&request_id=%s&weeks=%d", 
                            $this->host, $ref, UuidUtils::generate(), $weeks);

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($host);

            $data = $response->json();

            if ($response->successful() && 
                !is_null($data)) {
                
                if ($data['status']['code'] == 200) {
                    return  $data['data']['data'];

                } else {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));

                }

            } else {
                return $response->status();
            }
        }
    }

    public function getTokenTypesDetails(string $userRef) {
        if (!is_null($userRef)) {
            $host = sprintf("%s?user_ref=%s&request_id=%s&detailed_param=token-types", 
                            $this->host, $userRef, UuidUtils::generate());

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                        ->get($host);

            $data = $response->json();

            if ($response->successful() && 
                    !is_null($data)) {

                if ($data['status']['code'] == 200) {
                    return  $data['data']['result'];

                } else {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));

                }

            } else {
                return $response->status();

            }
        }
    }

    public function getTokenRequests(string $userRef) {
        if (!is_null($userRef)) {
            $host = sprintf("%s?user_ref=%s&request_id=%s", 
                            $this->host, $userRef, UuidUtils::generate());

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($host);

            $data = $response->json();

            if ($response->successful() && 
                !is_null($data)) {
                
                if ($data['status']['code'] == 200) {
                    return  $data['data']['tokens'];

                } else {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));

                }

            } else {
                return $response->status();
            }
        
        }
    }

    public function getTimelineRequests(array $criteria) {
        $userRef = $criteria['user-ref'];
        $months = $criteria['months'];

        if (!is_null($userRef) && !is_null($months)) {
            $host = sprintf("%s?user_ref=%s&request_id=%s&months=%s", 
                            $this->host, $userRef, UuidUtils::generate(), $months);

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($host);

            $data = $response->json();

            if ($response->successful() && 
                !is_null($data)) {
                
                if ($data['status']['code'] == 200) {
                    return $data['data']['requests'];

                } else {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));

                }

            } else {
                return $response->status();
            }
        
        }
    }

    public function getAggregate(string $userRef, string $param) {

        if (!is_null($userRef) && !is_null($param)) {

            $host = sprintf("%s?user_ref=%s&request_id=%s&param=%s", 
                            $this->host, $userRef, UuidUtils::generate(), $param);

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($host);

            $data = $response->json();

            if ($response->successful() && 
                !is_null($data)) {
                
                if ($data['status']['code'] == 200) {
                    return  $data['data']['result'];

                } else {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));

                }

            } else {
                return $response->status();
            }
        }
    }

    public function generateToken(string $userRef, string $stsConfigRef, array $params) {
        if (!is_null($userRef) && count($params) > 0 && !is_null($stsConfigRef)) {

            $configService = new ConfigService();
            $config = $configService->findByRef($userRef, $stsConfigRef, true);

            if (!is_null($config)) {

                if ($config['config']['activated']) {
                    $config['debug'] = false;

                    $url = sprintf("%s?user_ref=%s&request_id=%s", 
                                    $this->host, $userRef, UuidUtils::generate());
                    unset($config['config']);

                    $client = new \GuzzleHttp\Client();
                    $response = $client->post($url, [
                                                        'headers' => ['Content-type' => 'application/json'],
                                                        'auth' => [
                                                                $this->basicAuthUsername, 
                                                                $this->basicAuthPassword
                                                            ],
                                                            'json' => array_merge($config, $params),
                                                        ]);

                    $data = json_decode($response->getBody()->getContents(), true);

                    if (!is_null($data)){
                                                                    
                        if ($data['status']['code'] != 200) {
                            throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));
                                                        
                        } else {
                            return $data['data']['tokens'];
                                                        
                        }
                                                        
                    } else {
                        return $response->status();
                                                                            
                    }

                }
                throw new \Exception(sprintf('Config %s is not activated', $stsConfigRef));
            }
            throw new \Exception(sprintf('Invalid configuration %s returned', $stsConfigRef));
        }
    }

    public function decodeToken(string $userRef, string $stsConfigRef, string $token, string $drn) {

        if (!is_null($userRef) && !is_null($stsConfigRef) && !is_null($token)) {
            
            $configService = new ConfigService();
            $config = $configService->findByRef($userRef, $stsConfigRef, true);

            if (!is_null($config)) {

                if ($config['config']['activated']) {

                    $config['decoder_reference_number'] = $drn;

                    if ($config['config']['config_type'] == 'PRISM_THRIFT') {
                        $config['type'] = 'prism-thrift';
                    }

                    $url = sprintf("%s/%s?request_id=%s&user_ref=%s", 
                                    $this->host, $token, UuidUtils::generate(), $userRef);

                    unset($config['config']);

                    $client = new \GuzzleHttp\Client();
                    $response = $client->post($url, [
                                                    'headers' => ['Content-type' => 'application/json'],
                                                    'auth' => [
                                                        $this->basicAuthUsername, 
                                                        $this->basicAuthPassword
                                                    ],
                                                    'json' => $config,
                                                ]);

                    $data = json_decode($response->getBody()->getContents(), true);

                    if (!is_null($data)){
                                                            
                        if ($data['status']['code'] != 200) {
                            throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));
                                                        
                        } else {
                            return $data['data']['token_details'];
                                                        
                        }
                                                        
                    } else {
                        return $response->status();
                                                                            
                    }

                } else {
                    throw new \Exception(sprintf('Config %s for user %s not activated', $stsConfigRef, $userRef));
                }


            } else {
                
                throw new \Exception(sprintf('Config %s for user %s not found', $stsConfigRef, $userRef));
            }
        }
    }
}