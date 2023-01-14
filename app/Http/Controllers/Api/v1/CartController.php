<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\SendSMSEvent;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\v1\Cart\StoreCartRequest;
use App\Http\Requests\Api\v1\Cart\UpdateCartRequest;
use App\Http\Resources\Api\v1\Cart\CartResource;
use App\Models\Cart;
use App\Repositories\Cart\CartRepository;
use App\Services\Product\CalculateProductPriceService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends ApiController
{
    public function __construct(protected CartRepository $cartRepository, protected CalculateProductPriceService $calculateProductPriceService)
    {
    }

    public function index()
    {
        $carts = $this->cartRepository->paginateUser(relations: ["product"]);
        return self::success("ok", "carts list",
            [
                'products' => CartResource::collection($carts),
                'links' => CartResource::collection($carts)->response()->getData()->links,
                'meta' => CartResource::collection($carts)->response()->getData()->meta
            ]
        );
    }

    public function add(StoreCartRequest $request)
    {
        $priceSum = $this->calculateProductPriceService->sum($request->product_id, $request->quantity);
        $cart = $this->cartRepository->create(array_merge($request->validated(), ["user_id" => auth()->id(), "price_sum" => $priceSum]));
        return self::success("ok", "cart created successfully", new CartResource($cart->load(["user", "product"])), Response::HTTP_CREATED);
    }

    public function update(Cart $cart, UpdateCartRequest $request)
    {
        $this->authorize("user-cart", $cart);
        $quantity = is_null($request->quantity) ? $cart->quantity : $request->quantity;
        $productId = is_null($request->product_id) ? $cart->product_id : $request->product_id;
        $priceSum = $this->calculateProductPriceService->sum($productId, $quantity);
        $cart = $this->cartRepository->update($cart, array_merge($request->validated(), ["price_sum" => $priceSum]));
        return self::success("ok", "cart updated successfully", new CartResource($cart->load(["user", "product"])), Response::HTTP_ACCEPTED);
    }

    public function show($cart)
    {
        $cart = $this->cartRepository->findOrFail($cart, relations: ["product", "user"]);
        return self::success("ok", "cart show {$cart->id}", new CartResource($cart));
    }

    public function destroy(Cart $cart)
    {
        $this->cartRepository->delete($cart);
        return self::success("ok", "cart show {$cart->id}", new CartResource($cart->load(["user", "product"])), Response::HTTP_ACCEPTED);
    }

    public function submit()
    {
        $submitted = $this->cartRepository->submit(relations: "product");
        $submitted->map(function ($model) {
            $products[] = $model->product->name;
            SendSMSEvent::dispatch("100011", auth()->user()->phone_number, implode("\n", $products));
        });
        $user = auth()->user()->email;
        return self::success("ok", "carts for user {$user} are submitted", code: Response::HTTP_ACCEPTED);
    }

    public function getSubmitted()
    {
        $submittedCarts = $this->cartRepository->paginatedSubmitted(relations: ["product", "user"]);
        return self::success("ok", "submitted carts",
            [
                'carts' => CartResource::collection($submittedCarts),
                'links' => CartResource::collection($submittedCarts)->response()->getData()->links,
                'meta' => CartResource::collection($submittedCarts)->response()->getData()->meta
            ]
        );
    }
}
