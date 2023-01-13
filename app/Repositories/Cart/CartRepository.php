<?php

namespace App\Repositories\Cart;
use App\Models\Cart;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CartRepository extends BaseRepository
{
    public function __construct(Cart $model)
    {
        $this->model = $model;
    }

    /**
     * @param array|string $columns
     * @param array|string $relations
     * @param int $paginate
     * @param string $pageName
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public function paginateUser(array|string $columns = ["*"], array|string $relations = [], int $paginate = 15, string $pageName = 'page', int|null $page = null): LengthAwarePaginator
    {
        return $this->setBuilder($relations)->where("user_id", auth()->id())->paginate($paginate, $columns, $pageName, $page);
    }


    public function submit(): int
    {
        return $this->model->query()->whereNull("submitted_at")->where("user_id", auth()->id())->update(["submitted_at" => now()]);
    }

    public function paginatedSubmitted(array|string $columns = ["*"], array|string $relations = [], int $paginate = 15, string $pageName = 'page', int|null $page = null)
    {
        return $this->setBuilder($relations)->whereNotNull("submitted_at")->where("user_id", auth()->id())->paginate($paginate, $columns, $pageName, $page);
    }
}
