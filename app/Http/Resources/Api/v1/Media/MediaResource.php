<?php

namespace App\Http\Resources\Api\v1\Media;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            "original_url" => $this->original_url,
            "preview_url" => $this->preview_url
        ];
    }
}
