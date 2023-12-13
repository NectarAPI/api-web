<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Services\Contracts\ServiceInterface;
use App\Http\Utils\UuidUtils;

class PaymentService implements ServiceInterface {

    private $basicAuthUsername;
    private $basicAuthPassword;
    private $host;
    private $path;

    public function __construct() {
        $this->paymentsHost = config('payments-service.payments-host');
        $this->basicAuthUsername = config('payments-service.username');
        $this->basicAuthPassword = config('payments-service.password');
    }

    public function find(array $criteria) {
        try {
            
            $ref = $criteria['ref'];
            return $this->findByRef($ref);   

        } catch(\Exception $e) {
            throw $e;
            
        }     
    }

    public function findByRef(string $ref) {
        if (!is_null($ref)) {

            $host = sprintf("%s?ref=%s&request_id=%s", 
                            $this->paymentsHost, $ref, UuidUtils::generate());

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

    public function getPaymentsResultsDistribution(string $userRef) {
        if (!is_null($userRef)) {
            $host = sprintf("%s?user_ref=%s&request_id=%s&detailed_param=payments-results", 
                            $this->paymentsHost, $userRef, UuidUtils::generate());

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($host);

            $data = $response->json();

            if ($response->successful() && 
                !is_null($data)) {
                
                if ($data['status']['code'] == 200) {
                    return  $data['data']['payments'];

                } else {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));

                }

            } else {
                return $response->status();
            }
        
        }
    } 

    public function getPaymentsTotal(string $userRef) {
        if (!is_null($userRef)) {
            $host = sprintf("%s?user_ref=%s&request_id=%s", 
                            $this->paymentsHost, $userRef, UuidUtils::generate());

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($host);

            $data = $response->json();

            if ($response->successful() && 
                !is_null($data)) {
                
                if ($data['status']['code'] == 200) {
                    return  $data['data']['payments'];

                } else {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));

                }

            } else {
                return $response->status();
            }
        
        }
    }

    public function schedulePayment(string $userRef, int $amount, string $phoneNo) {
        if (!is_null($userRef) && !is_null($amount) && !is_null($phoneNo)) {
            $url = sprintf("%s?user_ref=%s&request_id=%s", 
                                    $this->paymentsHost, $userRef, UuidUtils::generate());

            $payload = array(
                'type' => 'MPESA',
                'amount' => $amount,
                'data' => array(
                    'phone_no' => $phoneNo
                )
            );

            $client = new \GuzzleHttp\Client();
            $response = $client->post($url, [
                                                'headers' => ['Content-type' => 'application/json'],
                                                'auth' => [
                                                        $this->basicAuthUsername, 
                                                        $this->basicAuthPassword
                                                    ],
                                                    'json' => $payload,
                                                ]);

            $data = json_decode($response->getBody()->getContents(), true);
 
            if (!is_null($data)){
                                                            
                if ($data['status']['code'] != 200) {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));
                                                        
                } else {
                    return $data['data']['transaction_ref'];
                                                        
                }
                                                        
            } else {
                return $response->status();
                                                                            
            }
        }
    }

    public function getPaymentStatus(string $userRef, string $transactionRef) {
        if (!is_null($userRef) && !is_null($transactionRef)) {
            $host = sprintf("%s?request_id=%s&ref=%s", 
                            $this->paymentsHost, UuidUtils::generate(), $transactionRef);

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($host);

            $data = $response->json();

            if ($response->successful() && 
                !is_null($data)) {
                
                if ($data['status']['code'] == 200) {
                    return  $data['data']['payment'];

                } else {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));

                }

            } else {
                return $response->status();
            }
        }
    }

}