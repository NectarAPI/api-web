<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Credits;
use App\Tokens;
use App\STSConfiguration;
use App\Services\UserService;
use App\Services\TokensService;
use App\Services\CreditsService;
use App\Services\ConfigService;

class TokensController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function getTimelineRequests(Request $request) {
        $userRef = Auth::user()->ref;
        $months = !is_null($request->months) ? $request->months : 6;

        try {
            if (!is_null($userRef)) {
                $tokens = new Tokens(new TokensService());
                $tokensTimelineRequests = $tokens->getTimelineRequests($userRef, $months);
                return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => 'obtained timeline data'
                                                    ],
                                                        'data' => $tokensTimelineRequests
                                                    ]);                

            } else {
                throw new \Exception('Invalid user ref');
            }

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }   
    }

    public function getTokenRequests(Request $request) {
        $userRef = Auth::user()->ref;

        try {
            if (!is_null($userRef)) {
                $tokens = new Tokens(new TokensService());
                $tokensRequests = $tokens->getTokenRequests($userRef);
                return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => 'obtained tokens data'
                                                    ],
                                                        'data' => $tokensRequests
                                                    ]);                

            } else {
                throw new \Exception('Invalid user ref');
            }

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }   
    }

    public function getNoOfConfigurations(Request $request) {
        return $this->makeConfigServiceAggregateRequest('configurations-no');
    }

    public function getNoOfGeneratedTokens(Request $request) {
        return $this->makeTokensAggregateRequest('generated-tokens');
    }

    public function getTypesOfTokens(Request $request) {
        return $this->makeTokensAggregateRequest('token-types');
    }

    public function getNoOfUniqueMeters(Request $request) {
        return $this->makeTokensAggregateRequest('unique-meters');
    }

    public function getNoOfCredits(Request $request) {
        return $this->makePaymentsCreditsAggregateRequest('credits-no');
    }

    public function getNoOfCredentials(Request $request) {
        return $this->makeUserServiceAggregateRequest('credentials-no');
    }

    public function getTokenTypesDetails(Request $request) {
        try {
            $userRef = Auth::user()->ref;
            if (!is_null($userRef)) {
                $tokens = new Tokens(new TokensService());
                $tokensData = $tokens->getTokenTypesDetails($userRef);
                return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => sprintf('obtained token types data')
                                                    ],
                                                        'data' => $tokensData
                                                    ]);  

            } else {
                throw new \Exception('Invalid user ref');
            }

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        } 
    }

    public function generateToken(Request $request) {
        try {
            $userRef = Auth::user()->ref;
            $params = $request->all();

            if (!is_null($userRef)) {
                if (!is_null($params)) {
                    
                    $stsConfigRef = $params['sts_config_ref'];

                    if (!is_null($stsConfigRef)) {
                        unset($params['sts_config_ref']);
                        
                        $tokens = new Tokens(new TokensService());
                        $generatedToken = $tokens->generateToken($userRef, $stsConfigRef, $params);

                        return response()->json(['status' => [
                                                                'code' => 200, 
                                                                'message' => 'Generated token'
                                                            ],
                                                            'data' => $generatedToken
                                                        ]);

                    } else {
                        throw new \Exception('Invalid STS config ref');
                    }

                } else {
                    throw new \Exception('Invalid params');
                }

            } else {
                throw new \Exception('Invalid user ref');
            }

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }
    }

    public function decodeToken(Request $request) {
        try {
            $userRef = Auth::user()->ref;
            $stsConfigRef = $request->sts_config_ref;
            $token = $request->token;
            $drn = $request->decoder_reference_number;
            
            if (!is_null($userRef)) {
                $tokens = new Tokens(new TokensService());
                $tokensData = $tokens->decodeToken($userRef, $stsConfigRef, $token, $drn);
                return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => sprintf('obtained token param')
                                                    ],
                                                    'data' => $tokensData
                                                ]);  
  
            } else {
                throw new \Exception('Invalid user ref');
            }



        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }
    }

    private function makeTokensAggregateRequest(string $param) {
        try {
            $userRef = Auth::user()->ref;
            if (!is_null($userRef)) {
                $tokens = new Tokens(new TokensService());
                $tokensData = $tokens->getAggregate($userRef, $param);
                return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => sprintf('obtained %s data', $param)
                                                    ],
                                                        'data' => $tokensData
                                                    ]);                

            } else {
                throw new \Exception('Invalid user ref');
            }

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }  
    }

    private function makePaymentsCreditsAggregateRequest(string $param) {
        try {
            $userRef = Auth::user()->ref;
            if (!is_null($userRef)) {
                $credits = new Credits(new CreditsService());
                $creditsAggregate = $credits->getAggregate($userRef, $param);
                return response()->json(['status' => [
                                                        'code' => 200, 
                                                        'message' => sprintf('obtained %s data', $param)
                                                    ],
                                                        'data' => $creditsAggregate
                                                    ]);                

            } else {
                throw new \Exception('Invalid user ref');
            }

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }  
    }

    private function makeUserServiceAggregateRequest(string $param) {
        try {
            $userRef = Auth::user()->ref;
            if (!is_null($userRef)) {
                $user = new User(new UserService());
                $credentials = $user->fetchCredentials($userRef);
                return response()->json(['status' => [
                                                    'code' => 200, 
                                                    'message' => sprintf('obtained %s data', $param)
                                                ],
                                                    'data' => count($credentials)
                                                ]);  
            } else {
                throw new \Exception('Invalid user ref');
            }
            
        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        }  
    }

    private function makeConfigServiceAggregateRequest(string $param) {
        try {
            $userRef = Auth::user()->ref;
            if (!is_null($userRef)) {
                $config = new STSConfiguration(new ConfigService());
                $configurations = $config->fetchSTSConfigurations($userRef);
                return response()->json(['status' => [
                                                    'code' => 200, 
                                                    'message' => sprintf('obtained %s data', $param)
                                                ],
                                        'data' => count($configurations)
                                    ]);  
            } else {
                throw new \Exception('Invalid user ref');
            }

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => ['code' => 500, 'message' => $e->getMessage()]]);

        } 
    }
}


