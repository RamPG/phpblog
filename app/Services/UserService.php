<?php


namespace App\Services;


use App\Services\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceInterface
{
    public function loginAttempt($requestData)
    {
        return Auth::attempt([
            'email' => $requestData['email'],
            'password' => $requestData['password'],
        ], isset($requestData['remember-me']));
    }
}
