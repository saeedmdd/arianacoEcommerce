<?php

namespace App\Http\Resources\Api\v1\Cart;

use App\Http\Resources\Api\v1\Product\ProductResource;
use App\Http\Resources\Api\v1\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "quantity" => $this->quantity,
            "product" => new ProductResource($this->whenLoaded("product")),
            "user" => new UserResource($this->whenLoaded("user")),
            "price_sum" => $this->price_sum
        ];
    }
}
