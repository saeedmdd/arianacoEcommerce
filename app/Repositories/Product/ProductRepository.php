<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;
class ProductRepository extends BaseRepository
{
    const MEDIA_COLLECTION = "product";
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

}
