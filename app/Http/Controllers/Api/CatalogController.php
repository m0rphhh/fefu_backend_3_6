<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use App\OpenApi\Responses\ListProductCategoriesResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\ShowProductCategoriesResponse;
use Illuminate\Contracts\Support\Responsable;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CatalogController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['productCategories'])]
    #[OpenApi\Response(factory: ListProductCategoriesResponse::class, statusCode: 200)]
    public function index()
    {
        return ProductCategoryResource::collection(ProductCategory::orderBy('created_at')->paginate(5));
    }

    /**
     * Display the specified resource
     *
     * @return Responsable
     * @param string $slug
     */
    #[OpenApi\Operation(tags: ['productCategories'])]
    #[OpenApi\Response(factory: ShowProductCategoriesResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function show(string $slug)
    {
        return ProductCategoryResource::make(ProductCategory::where('slug', $slug)->firstOrFail());
    }
}
