<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductListRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\OpenApi\Responses\ListProductResponse;
use App\OpenApi\Responses\NotFoundResponse;
use Illuminate\Contracts\Support\Responsable;
use App\OpenApi\Responses\ShowProductResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class ProductController extends Controller
{
    #[OpenApi\Operation(tags: ['products'])]
    #[OpenApi\Response(factory: ListProductResponse::class, statusCode: 200)]
    public function index(ProductListRequest $request)
    {
        $query = Product::query();
        if ($request->has('category_slug')) {
            $query->whereHas('productCategory', function($q) use ($request) {
                $q->where('slug', $request->input('category_slug'));
            });
        }

        $products = $query->paginate(5);

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
