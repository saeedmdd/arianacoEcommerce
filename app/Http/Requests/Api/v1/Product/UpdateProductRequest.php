<?php

namespace App\Http\Requests\Api\v1\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string|max:50",
            "description" => "required|string|max:500",
            "price" => "required|numeric|max:100000000",
            "images" => "nullable|array|size:3",
            "images.*" => "required|image|mimes:jpg,png",
            "status" => "bool"
        ];
    }
}
