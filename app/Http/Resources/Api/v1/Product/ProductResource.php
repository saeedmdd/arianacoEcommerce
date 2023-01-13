<?php

namespace App\Http\Resources\Api\v1\Product;

use App\Http\Resources\Api\v1\Discount\DiscountResource;
use App\Http\Resources\Api\v1\Media\MediaResource;
use App\Http\Resources\Api\v1\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "name" => $this->name,
            "description" => $this->description,
            "medias" => MediaResource::collection($this->whenLoaded('media')),
            "price" => $this->price,
            "status" => $this->status,
            "user" => new UserResource($this->whenLoaded('user')),
            'discounts' => DiscountResource::collection($this->whenLoaded("discounts")),
        ];
    }
}
