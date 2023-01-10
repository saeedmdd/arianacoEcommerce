<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function register()
    {

    }

    public function login()
    {

    }
}
