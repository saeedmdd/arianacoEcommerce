<?php

namespace App\Http\Resources\Api\v1\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "phone_number" => $this->phone_number,
            "token" => $this->token,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
