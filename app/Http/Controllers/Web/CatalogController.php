<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\CatalogFormRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Exception;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    private const PER_PAGE = 10;
    public function index(CatalogFormRequest $request, string $slug = null)
    {
        $query = ProductCategory::query()->with('children');

        if ($slug === null) {
            $query->where('parent_id');
        } else {
            $query->where('slug', $slug);
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

        return view('catalog.catalog', [
            'categories' => $categories,
            'products' => $productQuery->orderBy('products.id')->paginate(self::PER_PAGE),
            'filters' => $filters
        ]);
    }
}
