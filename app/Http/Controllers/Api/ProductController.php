<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\OpenApi\Responses\NotFoundResponse;
use Illuminate\Contracts\Support\Responsable;
use App\OpenApi\Responses\ShowProductResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class ProductController extends Controller
{
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
