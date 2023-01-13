<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\v1\User\LoginRequest;
use App\Http\Requests\Api\v1\User\RegisterRequest;
use App\Http\Resources\Api\v1\User\UserResource;
use App\Repositories\User\UserRepository;

class AuthController extends ApiController
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->userRepository->register($request->validated());
        return self::success("ok", "user created successfully",new UserResource($user));

    }

    public function login(LoginRequest $request)
    {
        $user = $this->userRepository->login($request->validated(),true);
        return self::success("ok", "user {$user->name} logged in successfully",new UserResource($user));
    }
}
