<?php

namespace App\Services\User;

use App\Models\User;
use Laravel\Sanctum\Contracts\HasApiTokens;

class UserService
{

    /**
     * @param User $model
     * @param string $name
     * @return string
     */
    public function getToken(User $model, string $name): string
    {
        return $model->createToken(name: $name)->plainTextToken;
    }

    /**
     * @param array $credentials
     * @param bool $remember
     * @return bool
     */
    public function login(array $credentials, bool $remember = false): bool
    {
        return auth()->attempt($credentials, $remember);
    }

}
