<?php

namespace App\Http\Requests\Api\v1\Discount;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountRequest extends FormRequest
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
            "percentage_discount" => "required|int|between:1,99",
            "expires_at" => "required|date_format:Y-m-d H:i:s"
        ];
    }
}
