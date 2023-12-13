<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Services\Contracts\ServiceInterface;
use App\Http\Utils\UuidUtils;

class CreditsService implements ServiceInterface {

    private $basicAuthUsername;
    private $basicAuthPassword;
    private $host;
    private $path;

    public function __construct() {
        $this->host = config('payments-service.credits-host');
        $this->basicAuthUsername = config('payments-service.username');
        $this->basicAuthPassword = config('payments-service.password');
    }

    public function find(array $criteria) {
        try {
            $creditRef = $criteria['ref'];
            
            if (!is_null($userRef) && !is_null($param)) {

                $host = sprintf("%s?user_ref=%s&request_id=%s&ref=%s", 
                                $this->host, $userRef, UuidUtils::generate(), $creditRef);
    
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

        } catch(\Exception $e) {
            throw $e;
            
        }    
    }

    public function getAggregate(string $userRef, string $param) {

        if (!is_null($userRef) && !is_null($param)) {

            $host = sprintf("%s?user_ref=%s&request_id=%s", 
                            $this->host, $userRef, UuidUtils::generate());

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($host);

            $data = $response->json();

            if ($response->successful() && 
                !is_null($data)) {
                
                if ($data['status']['code'] == 200) {
                    return  $data['data']['credits']['credits'];

                } else {
                    throw new \Exception(sprintf('Returned data for %s %s. %s', $param, $data['status']['code'], $data['status']['message']));

                }

            } else {
                return $response->status();
            }
        }
    }

    public function getTimelineCreditsCreditsConsumption(array $criteria) {
        $userRef = $criteria['user-ref'];
        $months = $criteria['months'];

        if (!is_null($userRef) && !is_null($months)) {
            $host = sprintf("%s?user=%s&request_id=%s&months=%s", 
                            $this->host, $userRef, UuidUtils::generate(), $months);

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($host);

            $data = $response->json();

            if ($response->successful() && 
                !is_null($data)) {
                
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

    public function getCreditsConsumption(array $criteria) {
        $userRef = $criteria['user-ref'];

        if (!is_null($userRef)) {
            $host = sprintf("%s?user_ref=%s&request_id=%s&all=false&detailed=true", 
                            $this->host, $userRef, UuidUtils::generate());

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($host);

            $data = $response->json();

            if ($response->successful() && 
                !is_null($data)) {
                
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
}