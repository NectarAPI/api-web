<?php

namespace App;

use Carbon\Carbon;

use App\Services\PaymentService;

class Payment
{

    private $service;

    public function __construct(PaymentService $service) {
        $this->service = $service;
    }

    public function getPaymentsTotal(string $userRef) {
        try {
            return $this->service->getPaymentsTotal($userRef);
            
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function getPaymentsResultsDistribution(string $userRef) {
        try {
            return $this->service->getPaymentsResultsDistribution($userRef);
            
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function schedulePayment(string $userRef, int $amount, string $phoneNo) {
        try {
            return $this->service->schedulePayment($userRef, $amount, $phoneNo);
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function getPaymentStatus(string $userRef, string $transactionRef) {
        try {
            return $this->service->getPaymentStatus($userRef, $transactionRef);
        } catch(\Exception $e) {
            throw $e;
        }
    }

}