<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductListRequest;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\OpenApi\Parameters\ProductParameters;
use App\OpenApi\Responses\ListProductResponse;
use App\OpenApi\Responses\NotFoundResponse;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use App\OpenApi\Responses\ShowProductResponse;
use Illuminate\Http\JsonResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class ProductController extends Controller
{
    private const PER_PAGE = 5;

    #[OpenApi\Operation(tags: ['products'])]
    #[OpenApi\Response(factory: ListProductResponse::class, statusCode: 200)]
    #[OpenApi\Parameters(factory: ProductParameters::class)]
    public function index(ProductListRequest $request)
    {
        $query = ProductCategory::query()->with('children', 'products');

        if (!$request->has('category_slug')) {
            $query->where('parent_id');
        } else {
            $query->where('slug', $request->input('category_slug'));
        }

        $categories = $query->get();
        try {
            $products = ProductCategory::getTreeProductsBuilder($categories)
                ->orderBy('id')
                ->paginate(self::PER_PAGE);
        } catch (Exception $exception) {
            abort(422, $exception->getMessage());
        }

        return ProductListResource::collection($products);
    }

    /**
     * Display the specified resource
     *
     * @return Responsable
     * @param string $slug
     */
    #[OpenApi\Operation(tags: ['products'])]
    #[OpenApi\Response(factory: ShowProductResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function show(string $slug)
    {
        $product = Product::query()
            ->with('productCategory', 'sortedAttributeValues.productAttribute')
            ->where('slug', $slug)
            ->firstOrFail();

        return ProductResource::make($product);
    }
}
