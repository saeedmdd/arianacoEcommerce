<?php

namespace App\Services\Product;

use App\Repositories\Product\ProductRepository;

class CalculateProductPriceService
{
    public function __construct(protected ProductRepository $productRepository)
    {
    }

    public function sum(int $productId, int $quantity): int
    {
        $price = $this->productRepository->findOrFail($productId,"price")->price;
        return ($price * $quantity);
    }
}
