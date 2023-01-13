<?php

namespace App\Repositories\Discount;

use App\Models\Discount;

class DiscountRepository extends \App\Repositories\BaseRepository
{
    public function __construct(Discount $model)
    {
        $this->model = $model;
    }

}
