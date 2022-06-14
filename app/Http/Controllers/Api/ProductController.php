<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\ProductListRequest;
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

    /**
     * Display the list of resources
     *
     * @param ProductListRequest $request
     * @return JsonResponse
     */
    #[OpenApi\Operation(tags: ['products'])]
    #[OpenApi\Response(factory: ListProductResponse::class, statusCode: 200)]
    #[OpenApi\Parameters(factory: ProductParameters::class)]
    public function index(ProductListRequest $request)
    {
        $query = ProductCategory::query()->with('children');

        if (!$request->has('category_slug')) {
            $query->where('parent_id');
        } else {
            $query->where('slug', $request->input('category_slug'));
        }

        $categories = $query->get();
        try {
            $productQuery = ProductCategory::getTreeProductsBuilder($categories);
        } catch (Exception $exception) {
            abort(422, $exception->getMessage());
        }

        $filters = ProductFilter::build($productQuery, $request->input('filters') ?? []);
        ProductFilter::apply($productQuery, $request->input('filters') ?? []);

        if ($request->has('search_query') && $request->input('search_query') !== null) {
            $productQuery->search($request->input('search_query'));
        }

        if ($request->input('sort_mode') == 'price_asc') {
            $productQuery->orderBy('price');
        } else if ($request->input('sort_mode') == 'price_desc') {
            $productQuery->orderBy('price', 'desc');
        }

        return new JsonResponse([
            'products' => ProductListResource::collection(
                $productQuery->orderBy('products.id')->paginate(self::PER_PAGE)
            ),

            'filters' => $filters,

            'sort' => [
                'order' => $request->input('sort_mode'),
                'search' => $request->input('search_query')
            ]
        ]);
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
