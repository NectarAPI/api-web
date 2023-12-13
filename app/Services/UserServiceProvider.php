<?php

namespace App\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Hash;

use App\User;


class UserServiceProvider implements UserProvider {

    private $model;

    public function __construct(User $user) {
        $this->model = $user;
    }

    public function retrieveById($identifier) {
        if (empty($identifier)) {
            return;
        }

        $user = $this->model->fetchUserByUsername($identifier);
        return $user;
    }

   public function retrieveByToken($identifier, $token) {
        if (empty($identifier) || empty($token)) {
            return;
        }

        $user = $this->model->fetchUserByRefAndToken($identifier, $token);
        return $token && $user ? $user : null;
   }

   public function updateRememberToken(Authenticatable $user, $token) {
        if (is_null($user) || empty($token)) {
            return;
        }

        $this->model->updateToken($user, $token);
   }

   public function retrieveByCredentials(array $credentials) {
       try {
            if (empty($credentials)) {
                return;
            }
            $user = $this->model->fetchUserByCredentials(['username' => $credentials['username']]);
            return $user;

        } catch(\Exception $e) {
            throw $e;

        }
   }

   public function validateCredentials(Authenticatable $user, array $credentials) {
        $user = $this->retrieveByCredentials($credentials);
        return ($credentials['username'] == $user->getAuthIdentifier() &&
                Hash::check($credentials['password'], $user->getAuthPassword()));
   }

}