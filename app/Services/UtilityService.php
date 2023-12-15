<?php

namespace App\Services;

class UtilityService {

    public function __construct() {
        $this->host = config('utility-service.host');
        $this->basicAuthUsername = config('utility-service.username');
        $this->basicAuthPassword = config('utility-service.password');
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
                    throw new \Exception(sprintf('User service returned status %s. %s', $data['status']['code'], $data['status']['message']));
                }

            } else {
                return $response->status();
            }
        }
    }
}