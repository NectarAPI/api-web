<?php

namespace App;

use Carbon\Carbon;

use App\Services\TokensService;

class Tokens
{

    private $service;

    public function __construct(TokensService $service) {
        $this->service = $service;
    }

    public function getTimelineRequests(string $userRef, int $months) {
        try {
            return $this->service->getTimelineRequests(['user-ref' => $userRef, 'months' => $months]);

        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function getAggregate(string $ref, string $param) {
        try {
            return $this->service->getAggregate($ref, $param);
            
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function getTokenRequests(string $userRef) {
        try {
            return $this->service->getTokenRequests($userRef);
            
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function getTokenTypesDetails(string $userRef) {
        try {
            return $this->service->getTokenTypesDetails($userRef);
            
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function generateToken(string $userRef, string $stsConfigRef, array $params) {
        try {
            return $this->service->generateToken($userRef, $stsConfigRef, $params);
            
        } catch(\Exception $e) {
            throw $e;
        }
    }
   
    public function decodeToken(string $userRef, string $stsConfigRef, 
                                string $token, string $drn) {
        try {
            return $this->service->decodeToken($userRef, $stsConfigRef, $token, $drn);
            
        } catch(\Exception $e) {
            throw $e;
        }
    }

}