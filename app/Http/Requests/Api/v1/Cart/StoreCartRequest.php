<?php

namespace App\Http\Requests\Api\v1\Cart;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
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
    public function rules()
    {
        return [
            "quantity" => "required|integer|max:10000",
            "product_id" => "required|exists:products,id"
        ];
    }
}
