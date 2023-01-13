<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Product\StoreProductRequest;
use App\Http\Requests\Api\v1\Product\UpdateProductRequest;
use App\Http\Resources\Api\v1\Product\ProductResource;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Services\UploadService\UploadService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends ApiController
{

    public function __construct(protected ProductRepository $productRepository, protected UploadService $uploadService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepository->paginate(relations: ['media', 'discounts', 'user']);
        return self::success("ok", "Products list",
            [
                'products' => ProductResource::collection($products),
                'links' => ProductResource::collection($products)->response()->getData()->links,
                'meta' => ProductResource::collection($products)->response()->getData()->meta
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productRepository->create(array_merge($request->validated(), ["user_id" => auth()->user()->id]));
        try {
            $this->uploadService->upload($product, ProductRepository::MEDIA_COLLECTION);
        } catch (FileDoesNotExist|FileIsTooBig $e) {
            return self::error($e->getMessage());
        }
        return self::success(
            "ok",
            "Product {$product->name} created successfully",
            new ProductResource($product->load(["media", "user", "discounts"])),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $product
     * @return JsonResponse
     */
    public function show(int $product): JsonResponse
    {
        $product = $this->productRepository->findOrFail(modelId: $product, relations: ["user", "media", "discounts"]);
        return self::success("ok", "Product number {$product->id}", new ProductResource($product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize("user-product", $product);
        if (!is_null($request->images))
            $product->media()->delete();
        $product = $this->productRepository->update($product, $request->validated());
        try {
            $this->uploadService->upload($product, "updated");
        } catch (FileDoesNotExist|FileIsTooBig $e) {
            return self::error($e->getMessage());
        }
        return self::success("ok", "Product {$product->name} updated", new ProductResource($product->load(["user", "media", "discounts"])), Response::HTTP_ACCEPTED);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->productRepository->delete($product);
        $product->media()->delete();
        return self::success("ok", "product {$product->name} is deleted");
    }
}
