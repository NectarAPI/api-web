<?php

namespace App;

use Carbon\Carbon;

use App\Services\CredentialsService;

class Credentials
{

    private $service;

    public function __construct(CredentialsService $service) {
        $this->service = $service;
    }

    public function fetchCredentials(string $userRef) {
        try {
            return $this->service->find(['user-ref' => $userRef]);

        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function addCredentials(string $userRef, array $permissionsIds) {
        try {
            return $this->service->addCredentials($userRef, $permissionsIds);

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getPermissions() {
        try {
            return $this->service->getPermissions();

        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function setCredentialStatus(string $credentialRef, string $status, string $userRef) {
        try {
            return $this->service->setCredentialStatus($credentialRef, $status, $userRef);
            
        } catch (\Exception $e) {
            throw $e;
        }
    }

}