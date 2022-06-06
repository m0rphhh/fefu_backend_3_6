<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(string $slug = null)
    {
        $query = ProductCategory::query()->with('children');

        if ($slug == null) {
            $query->where('parent_id');
        } else {
            $query->where('slug', $slug);
        }

        return view('catalog.catalog', ['categories' => $query->get()]);
    }
}
