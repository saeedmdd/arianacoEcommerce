<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Throwable;

abstract class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    /**
     * @param array|string $relations
     * @return Builder
     */
    protected function setBuilder(array|string $relations = []): Builder
    {
        return $this->model->with($relations);
    }

    /**
     * @param array|string $columns
     * @param array|string $relations
     * @return Collection
     */
    public function getAll(array|string $columns = ["*"], array|string $relations = []): Collection
    {
        return $this->setBuilder($relations)->get($columns);
    }

    /**
     * @param int $modelId
     * @param array|string $columns
     * @param array|string $relations
     * @param array|string $appends
     * @return Model|null
     */
    public function findOrFail(int $modelId, array|string $columns = ["*"], array|string $relations = [], array|string $appends = []): ?Model
    {
        return $this->setBuilder($relations)->findOrFail($modelId, $columns)->append($appends);
    }

    /**
     * @param Model $model
     * @param array $columns
     * @return Model|null
     */
    public function create(array $columns): ?Model
    {
        return $this->model->query()->create($columns);
    }

    /**
     * @param Model $model
     * @param array $columns
     * @return bool
     */
    public function update(Model $model, array $columns): bool
    {
        return $model->update($columns);
    }

    /**
     * @param Model $model
     * @return bool
     * @throws Throwable
     */
    public function delete(Model $model): bool
    {
        return $model->deleteOrFail();
    }

    /**
     * @param array|string $columns
     * @param array|string $relations
     * @param int $paginate
     * @param string $pageName
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public function paginate(array|string $columns = ["*"], array|string $relations = [], int $paginate = 15, string $pageName = 'page', int|null $page = null): LengthAwarePaginator
    {
        return $this->setBuilder($relations)->paginate($paginate, $columns, $pageName, $page);
    }
}
