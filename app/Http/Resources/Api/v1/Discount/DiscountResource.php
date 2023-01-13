<?php

namespace App\Http\Resources\Api\v1\Discount;

use App\Http\Resources\Api\v1\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "code" => $this->code,
            "percentage_discount" => $this->percentage_discount,
            "expires_at" => $this->expires_at,
            "product" => new ProductResource($this->whenLoaded("product"))
        ];
    }
}
