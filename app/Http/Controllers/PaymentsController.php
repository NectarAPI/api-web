<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Payment;
use App\Credits;
use App\Services\PaymentService;
use App\Services\CreditsService;

class PaymentsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function getPaymentsTotal(Request $request) {
        $userRef = Auth::user()->ref;

        try {
            if (!is_null($userRef)) {
                $payment = new Payment(new PaymentService());
                $paymentData = $payment->getPaymentsTotal($userRef);
                return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => 'obtained payments data'
                                                    ],
                                                        'data' => $paymentData
                                                    ]);                

            } else {
                throw new \Exception('Invalid user ref');
            }

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }   
    }

    public function getPaymentsResultsDistribution(Request $request) {
        $userRef = Auth::user()->ref;

        try {
            if (!is_null($userRef)) {
                $payment = new Payment(new PaymentService());
                $paymentData = $payment->getPaymentsResultsDistribution($userRef);
                return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => 'obtained payments distribution data'
                                                    ],
                                                        'data' => $paymentData
                                                    ]);                

            } else {
                throw new \Exception('Invalid user ref');
            }

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }  
    }

    public function getTimelineCreditsCreditsConsumption(Request $request) {
        $userRef = Auth::user()->ref;
        $months = !is_null($request->months) ? $request->months : 6;

        try {
            if (!is_null($userRef)) {
                $credits = new Credits(new CreditsService());
                $creditsTimelineRequests = $credits->getTimelineCreditsCreditsConsumption($userRef, $months);
                return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => 'obtained timeline data'
                                                    ],
                                                        'data' => $creditsTimelineRequests
                                                    ]);                

            } else {
                throw new \Exception('Invalid user ref');
            }

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }   
    }

    public function getCreditsConsumption(Request $request) {
        $userRef = Auth::user()->ref;

        try {
            if (!is_null($userRef)) {
                $credits = new Credits(new CreditsService());
                $creditsData = $credits->getCreditsConsumption($userRef);
                return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => 'obtained credits and consumption data'
                                                    ],
                                                        'data' => $creditsData
                                                    ]);                

            } else {
                throw new \Exception('Invalid user ref');
            }

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }
    }

    public function schedulePayment(Request $request) {
        try {
            $userRef = Auth::user()->ref;
            $amount = $request->amount;
            $phoneNo = $request->phone_no;

            if (!is_null($userRef)) {
                if (!is_null($amount) && preg_match("/^\d+$/", $amount)) {
                    if (!is_null($phoneNo) && preg_match("/^254[0-9]{9}$/", $phoneNo)) {
                        $payment = new Payment(new PaymentService());
                        $queuedTransactionRef = $payment->schedulePayment($userRef, $amount, $phoneNo);

                        return response()->json(['status' => [
                                                                'code' => 200, 
                                                                'message' => 'Scheduled payment'
                                                            ],
                                                                'transaction_ref' => $queuedTransactionRef
                                                        ]);

                    } else {
                        throw new \Exception('Invalid phone no');
                    }

                } else {
                    throw new \Exception('Invalid amount');
                }

            } else {
                throw new \Exception('Invalid user ref');
            }

        } catch(\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);
        }
    }


    public function getPaymentStatus(Request $request) {
        try {
            $userRef = Auth::user()->ref;
            $transactionRef = $request->ref;

            if (!is_null($transactionRef)) {
                $payment = new Payment(new PaymentService());
                $paymentStatus = $payment->getPaymentStatus($userRef, $transactionRef);

                return response()->json(['status' => [
                                        'code' => 200, 
                                        'message' => 'Obtained transaction status'
                                    ],
                                    'payment_status' => $paymentStatus
                                ]);

            } else {
                throw new \Exception('Invalid transaction ref');
            }

        } catch(\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);
        }
    }

}
