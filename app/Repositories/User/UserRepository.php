<?php

namespace App\Repositories\User;

use App\Http\Requests\Api\v1\User\LoginRequest;
use App\Models\Product;
use App\Repositories\BaseRepository;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository
{
    public function __construct(User $model, protected UserService $userService)
    {
        $this->model = $model;
    }

    public function findByEmail(string $email, array|string $relations = [], array|string $columns = ["*"], array|string $appends = []): Model|\Illuminate\Database\Eloquent\Builder
    {
        return $this->setBuilder($relations)->where("email", $email)->firstOrFail($columns)->append($appends);
    }

    /**
     * @param array $columns
     * @return Model|null
     */
    public function register(array $columns): ?Model
    {
        $user = parent::create($columns);
        $user->token = $this->userService->getToken($user, env("APP_NAME"));
        return $user;
    }


    public function login(array $credentials, bool $remember, array|string $relations = [], array|string $columns = ["*"], array|string $appends = []): ?User
    {
        if ($this->userService->login($credentials, $remember)) {
            $user = $this->findByEmail($credentials["email"], $relations, $columns, $appends);
            $user->token = $this->userService->getToken($user, env("APP_NAME"));
            return $user;
        }
        return null;
    }
}
