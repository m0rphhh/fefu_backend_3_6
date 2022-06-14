<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(string $slug)
    {
        $product = Product::query()
            ->with('productCategory', 'sortedAttributeValues.productAttribute')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('product.index', ['product' => $product]);
    }
}
