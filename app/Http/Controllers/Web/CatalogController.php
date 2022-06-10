<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(string $slug = null)
    {
        $query = ProductCategory::query()->with('children', 'products');

        if ($slug === null) {
            $query->where('parent_id');
        } else {
            $query->where('slug', $slug);
        }

        $categories = $query->get();
        $products = ProductCategory::getTreeProductsBuilder($categories)
            ->orderBy('id')
            ->paginate();

        return view('catalog.catalog', ['categories' => $categories, 'products' => $products]);
    }
}
