<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\v1\Discount\StoreDiscountRequest;
use App\Http\Requests\Api\v1\Discount\UpdateDiscountRequest;
use App\Http\Resources\Api\v1\Discount\DiscountResource;
use App\Models\Discount;
use App\Repositories\Discount\DiscountRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class DiscountController extends ApiController
{

    public function __construct(protected DiscountRepository $discountRepository)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDiscountRequest $request
     * @return JsonResponse
     */
    public function store(StoreDiscountRequest $request): JsonResponse
    {
        $discount = $this->discountRepository->create($request->validated());
        return self::success("ok", "Discount created", new DiscountResource($discount->load("product")), Response::HTTP_CREATED);
    }


    /**
     * @param UpdateDiscountRequest $request
     * @param Discount $discount
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateDiscountRequest $request, Discount $discount): JsonResponse
    {
        $this->authorize("user-product", $discount->product);
        $discount = $this->discountRepository->update($discount, $request->validated());
        return self::success("ok", "Discount updated", new DiscountResource($discount->load("product")), Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Discount $discount
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(Discount $discount): JsonResponse
    {
        $this->discountRepository->delete($discount);
        return self::success("ok", "Discount updated", code: Response::HTTP_CREATED);
    }
}
