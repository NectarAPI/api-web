<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Services\Contracts\ServiceInterface;
use App\Http\Utils\UuidUtils;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserService implements ServiceInterface {

    private $basicAuthUsername;
    private $basicAuthPassword;
    private $host;
    private $path;

    public function __construct() {
        $this->host = config('user-service.host');
        $this->credentialsHost = config('user-service.credentials-host');
        $this->basicAuthUsername = config('user-service.username');
        $this->basicAuthPassword = config('user-service.password');
    }

    public function find(array $criteria) {
        try {
            
            $username = $criteria['username'];
            return $this->findByUsername($username);   

        } catch(\Exception $e) {
            throw $e;
            
        }     
    }

    public function getCredentials(string $userRef) {
        try {
            if (!is_null($userRef)) {
                $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                                ->get($this->credentialsHost, [
                                                'request_id' => UuidUtils::generate(),
                                                'user_ref' => $userRef
                                             ]);
    
                $data = $response->json();

                if ($response->successful() && !is_null($data)) {
                    if ($data['status']['code'] == 200) {
                        return $data['data']['data'];
    
                    } else {
                        throw new \Exception(sprintf('User service returned status %s. %s', $data['status'], $data['message']));
                    }
    
                } else {
                    return $response->status();
                }
            }

        } catch(\Exception $e) {
            throw $e;
            
        }  
    }

    public function findByUsername(String $username) {

        if (!is_null($username)) {
            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($this->host, [
                                            'request_id' => UuidUtils::generate(),
                                            'username' => $username
                                         ]);

            $data = $response->json();

            if ($response->successful() && !is_null($data)) {
                
                if ($data['status']['code'] == 200) {
                    return $data['data']['user'];

                } else {
                    throw new \Exception(sprintf('User service returned status %s. %s', $data['status']['code'], $data['status']['message']));
                }

            } else {
                return $response->status();
            }
        }
    }

    public function findByEmail(String $email) {

        if (!is_null($email)) {
            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($this->host, [
                                            'request_id' => UuidUtils::generate(),
                                            'email' => $email
                                         ]);

            $data = $response->json();

            if ($response->successful() && !is_null($data)) {
                if ($data['status']['code'] == 200) {
                    return $data['data']['user'];

                } else {
                    throw new \Exception(sprintf('User service returned status %s. %s', $data['status']['code'], $data['status']['message']));
                }

            } else {
                return $response->status();
            }
        }
    }

    public function findByRef(String $ref) {
        if (!is_null($ref)) {

            $host = sprintf("%s?ref=%s&request_id=%s", $this->host, $ref, UuidUtils::generate());

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($host);

            $data = $response->json();

            if ($response->successful() && 
                !is_null($data)) {
                
                    if ($data['status']['code'] == 200) {
                        return $data['data']['user'];
    
                    } else {
                        throw new \Exception(sprintf('User service returned status %s. %s', $data['status']['code'], $data['status']['message']));
                    }

            } else {
                return $response->status();
            }
        }
    }

    public function setLoginUserActivityLog(string $userRef) {
        if (!is_null($userRef)) {

            $requestId = UuidUtils::generate();
            $host = sprintf("%s/%s/activity?request_id=%s", $this->host, $userRef, $requestId);

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->post($host, 
                                        [   
                                            'category' => 'LOGIN',
                                            'description' => sprintf('Nectar API Portal Login. [Request-ID: %s]', $requestId),
                                        ]);

            $data = $response->json();

            if (!is_null($data)){

                if ($data['status']['code'] != 200) {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));

                } else {
                    return $data['data']['user_activity_log_ref'];

                }

            } else {
                return $response->status();
                
            }
        }
    }

    public function getActivityLog(string $userRef) {
        if (!is_null($userRef)) {
            $host = sprintf("%s/%s/activity", $this->host, $userRef);

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($host, [
                                                'request_id' => UuidUtils::generate()
                                            ]);
                    
            $data = $response->json();

            if ($response->successful() && 
                    !is_null($data)) {
                                                    
                if ($data['status']['code'] == 200) {
                    return $data['data']['user_activity_logs'];
                                    
                } else {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));
                                    
                }
                                    
            } else {
                return $response->status();
            }
        }    
    }

    public function findByRefAndToken(string $ref, string $rememberToken) {
        if (!is_null($ref) && !is_null($rememberToken)) {

            $host = sprintf("%s?ref=%s&remember_token=%s", $this->host, $ref, $rememberToken);

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->get($this->host, [
                                                'request_id' => UuidUtils::generate(),
                                                'ref' => $ref,
                                                'remember_token' => $rememberToken
                                                ]);

            $data = $response->json();

            if ($response->successful() && 
                !is_null($data)) {
                
                    if ($data['status']['code'] == 200) {
                        return $data['data']['user'];
    
                    }

            }
        }
    }

    public function updatePassword(Authenticatable $user, string $password) {
        if (!is_null($user) && !empty($password)) {

            $host = sprintf("%s?ref=%s&password=%s&request_id=%s", 
                            $this->host, $user->ref, $password, UuidUtils::generate());

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->put($host);

                $data = $response->json();

                if ($response->successful() && !is_null($data)) {

                if ($data['status']['code'] != 200) {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status'], $data['message']));

                } else {
                    return $response->status();
                }
            }
        }
    }

    public function updateToken(Authenticatable $user, $token) {
        if (!is_null($user) && !empty($token)) {

            $host = sprintf("%s?ref=%s&remember_token=%s", $this->host, $user->ref, $token);

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->put($host, [
                                'request_id' => UuidUtils::generate()
                            ]);

                $data = $response->json();

                if ($response->successful() && !is_null($data)) {

                if ($data['status']['code'] != 200) {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));

                } else {
                    return $response->status();
                }
            }
        }
    }

    public function updateEmailVerifiedAt(Authenticatable $user, Carbon $dateTime) {
        if (!is_null($user) && !empty($dateTime)) {

            $host = sprintf("%s?ref=%s&email_verified_at=%d&request_id=%s", 
                            $this->host, $user->ref, $dateTime->timestamp, UuidUtils::generate());

            $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->put($host);

                $data = $response->json();

                if ($response->successful() && !is_null($data)) {

                if ($data['status']['code'] != 200) {
                    throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));

                } else {
                    return $response->status();
                }
            }
        }
    }

    public function createUser(string $firstName, string $lastName, string $username,
                                string $phoneNo, string $imageURL, string $email, string $password) {

        if (!is_null($firstName) && !is_null($lastName) && !is_null($username) &&
            !is_null($phoneNo) && !is_null($email) && !is_null($password)) {

                $host = sprintf("%s?request_id=%s&user_ref=%s", $this->host,  UuidUtils::generate(), env('ROOT_USER_REF'));

                $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                            ->post($host, 
                                        [   
                                            'first_name' => $firstName,
                                            'last_name' => $lastName,
                                            'username' => $username,
                                            'email' => $email,
                                            'phone_no' => $phoneNo,
                                            'password' => $password,
                                            'image_url' => $imageURL
                                        ]);
   
                $data = $response->json();

                if (!is_null($data)){

                    if ($data['status']['code'] != 200) {
                        throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));

                    } else {
                        return $data['data']['user_ref'];

                    }

                } else {
                    return $response->status();
                    
                }
        }
    }

    public function updateUser(string $ref, string $firstName, string $lastName, string $phoneNo, 
                                ?string $imageURL, string $email, ?string $password) {
        
        if (!is_null($ref) && !is_null($firstName)
            && !is_null($lastName) && !is_null($phoneNo) 
            && !is_null($email)) {
                        
                $user = array('first_name' => $firstName,
                                'last_name' => $lastName,
                                'email' => $email,
                                'phone_no' => $phoneNo
                            );

                if (!empty($imageURL)) {
                    $user['image_url'] = $imageURL;
                }

                if (!empty($password)) {
                    $user['password'] = $password;
                }

                $url = sprintf("%s?ref=%s&request_id=%s", $this->host, $ref,  UuidUtils::generate());

                $client = new \GuzzleHttp\Client();    
                $response = $client->put($url, [
                                                'headers' => ['Content-type' => 'application/json'],
                                                'auth' => [
                                                    $this->basicAuthUsername, 
                                                    $this->basicAuthPassword
                                                ],
                                                'json' => $user,
                                            ]);
                
                $data = json_decode($response->getBody()->getContents(), true);
                  
                if (!is_null($data)){
                        
                    if ($data['status']['code'] != 200) {
                        throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));
                        
                    } else {
                        return $data['status']['requestId'];
                        
                    }
                        
                } else {
                    return $response->status();
                                            
                }
            } else {
                throw new \Exception('Missing update user parameters');
            }
    }

}