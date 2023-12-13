<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Http\Utils\UuidUtils;

class NotificationsService {

    private $basicAuthUsername;
    private $basicAuthPassword;
    private $host;
    private $path;

    public function __construct() {
        $this->host = config('notifications-service.host');
        $this->basicAuthUsername = config('notifications-service.username');
        $this->basicAuthPassword = config('notifications-service.password');
    }

    public function fetchNotifications(array $criteria) {
        try {
            $userRef = $criteria['user-ref'];
            $offset = $criteria['offset'];
            $limit = $criteria['limit'];
            
            if (!is_null($userRef)) {
                $response = Http::withBasicAuth($this->basicAuthUsername, $this->basicAuthPassword)
                                ->get($this->host, [
                                                'request_id' => UuidUtils::generate(),
                                                'user_ref' => $userRef,
                                                'offset' => $offset,
                                                'limit' => $limit
                                             ]);
    
                $data = $response->json();

                if ($response->successful() && !is_null($data)) {
                    if ($data['status']['code'] == 200) {
                        return $data['data']['notifications'];
    
                    } else {
                        throw new \Exception(sprintf('User service returned status %s. %s', $data['status']['code'], $data['status']['message']));
                    }
    
                } else {
                    return $response->status();
                }
            }

        } catch(\Exception $e) {
            throw $e;
            
        }    
    }

    public function setReadNotifications(string $userRef, array $notificationsRefs) {
        try {
            if (!is_null($userRef) && count($notificationsRefs) > 0) {
                $url = sprintf("%s?request_id=%s", $this->host, UuidUtils::generate());

                $selectedNotifications = array();

                foreach ($notificationsRefs as $notificationRef) {
                    array_push($selectedNotifications, 
                                    array('user_ref' => $userRef, 
                                            'notification_ref' => $notificationRef, 
                                            'status' => true, 
                                            'read_timestamp' => time()));
                }

                $client = new \GuzzleHttp\Client();

                $response = $client->put($url, [
                                                'headers' => ['Content-type' => 'application/json'],
                                                'auth' => [
                                                        $this->basicAuthUsername, 
                                                        $this->basicAuthPassword
                                                    ],
                                                'json' => $selectedNotifications
                                                
                                                ]);
                
                $data = json_decode($response->getBody()->getContents(), true);

                if (!is_null($data)){
                            
                    if ($data['status']['code'] != 200) {
                        throw new \Exception(sprintf('Returned status %s. %s', $data['status']['code'], $data['status']['message']));
                        
                    } else {
                        return $data['status']['message'];;
                        
                    }
                        
                } else {
                    return $response->status();
                                            
                }
            }

        } catch(\Exception $e) {
            throw $e;
        }
    }

}