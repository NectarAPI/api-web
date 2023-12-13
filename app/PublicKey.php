<?php

namespace App;

use Carbon\Carbon;

use App\Services\PublicKeyService;

class PublicKey
{

    private $service;

    public function __construct(PublicKeyService $service) {
        $this->service = $service;
    }

    public function fetchPublicKeys(string $userRef) {
        try {
            return $this->service->find(['user-ref' => $userRef]);

        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function setPublicKey(string $userRef, string $name, string $key, bool $activated) {
        try {
            return $this->service->setPublicKey($userRef, $name, $key, $activated);

        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function activatePublicKey(string $keyRef, string $userRef) {
        try {
            return $this->service->activatePublicKey($keyRef, $userRef);

        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function deactivatePublicKey(string $keyRef, string $userRef) {
        try {
            return $this->service->deactivatePublicKey($keyRef, $userRef);

        } catch(\Exception $e) {
            throw $e;

        }
    }

}