<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

use App\Services\UserService;

class User extends Authenticatable
{
    public $firstName;
    public $lastName;
    public $username;
    public $phoneNo;
    public $imageURL;
    public $ref;
    public $email;
    public $password;
    public $activated;

    private $service;

    public function __construct(UserService $service) {
        $this->service = $service;
    }

    public function fetchUserByCredentials(Array $credentials) {
        try {
            $obtainedUser = $this->service->find(['username' => $credentials['username']]);

            if (!is_null($obtainedUser)) {
                $this->populateUser($obtainedUser);
                
            }

            return $this;

        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function fetchCredentials(string $userRef) {
        try {
            return $this->service->getCredentials($userRef);

        } catch(\Exception $e) {
            throw $e;

        }
    }

    public function fetchUserByUsername(String $username) {
        $obtainedUser = $this->service->findByUsername($username);

        if (!is_null($obtainedUser)) {
            $this->populateUser($obtainedUser);
        }

        return $this;
    }

     public function fetchByEmail(String $email) {
        $obtainedUser = $this->service->findByEmail($email);

        if (!is_null($obtainedUser)) {
            $this->populateUser($obtainedUser);
        }

        return $this;
     }

    public function fetchUserByRef(String $ref) {
        $obtainedUser = $this->service->findByRef($ref);

        if (!is_null($obtainedUser)) {
            $this->populateUser($obtainedUser);
        }

        return $this;
    }

    private function populateUser($user) {
        $this->firstName = $user['first_name'];
        $this->lastName = $user['last_name'];
        $this->username = $user['username'];
        $this->phoneNo = $user['phone_no'];
        $this->imageURL = $user['image_url'];
        $this->ref = $user['ref'];
        $this->email = $user['email'];
        $this->password = $user['password'];
        $this->activated = $user['activated'];
    }

    public function fetchUserByRefAndToken(string $identifier, string $rememberToken) {
        $obtainedUser = $this->service->findByRefAndToken($identifier, $rememberToken);

        if (!is_null($obtainedUser)) {
            $this->populateUser($obtainedUser);
            
        }

        return $this;
    }

    public function updateToken(Authenticatable $user, $token) {
        if (!is_null($user) && !empty($user)) {
            $this->service->updateToken($user, $token);
        }
    }

    public function updatePassword(Authenticatable $user, string $password) {
        if (!is_null($user) && !empty($user) && 
            !is_null($password) && !empty($password)) {
            $this->service->updatePassword($user, $password);
        }
    }

    public function updateEmailVerifiedAt(Authenticatable $user, Carbon $dateTime) {
        if (!is_null($user) && !empty($dateTime)) {
            $this->service->updateEmailVerifiedAt($user, $dateTime);
        }
    }

    public function getAuthIdentifier() {
        return $this->{$this->getAuthIdentifierName()};
    }

    public function getAuthIdentifierName() {
        return "username";
    }

    public function getAuthPassword() {
        return $this->password;
    }

    public function createUser(string $firstName, string $lastName, string $username, 
                                string $phoneNo, string $imageURL, string $email, string $password) {
        try {
            return $this->service->createUser($firstName, $lastName, $username, 
                                                $phoneNo, $imageURL, $email, $password);

        } catch(\Exception $e) {
            throw $e;
                        
        }
    }

    public function setLoginUserActivityLog(string $userRef) {
        try {
            return $this->service->setLoginUserActivityLog($userRef);
            
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function getActivityLog(string $userRef) {
        try {
            return $this->service->getActivityLog($userRef);
            
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function updateUser(string $ref, string $firstName, string $lastName, string $phoneNo, 
                                ?string $imageURL, string $email, ?string $password) {
        try {
                return $this->service->updateUser($ref, $firstName, $lastName, $phoneNo, 
                                                    $imageURL, $email, $password);
                            
        } catch(\Exception $e) {
            throw $e;
                                                    
        }
    }

    public function fetchUtilities(string $userRef) {
        try {
            return $this->service->findUtilitiesByUserRef($userRef);
        } catch(\Exception $e) {
            throw $e;
        }
    }

}
