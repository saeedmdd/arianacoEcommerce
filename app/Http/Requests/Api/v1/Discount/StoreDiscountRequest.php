<?php

namespace App\Http\Requests\Api\v1\Discount;

use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreDiscountRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $product = Product::findOrFail($this->product_id);
        return Gate::authorize( "user-product",$product);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            "code" => "required|string|unique:discounts,code",
            "percentage_discount" => "required|int|between:1,99",
            "product_id" => "required|int|exists:products,id",
            "expires_at" => "required|date_format:Y-m-d H:i:s"
        ];
    }
}
