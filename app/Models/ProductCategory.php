<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name', 'slug', 'parent_id'
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @throws Exception
     */
    public static function getTreeProductsBuilder(Collection $categories): Builder
    {
        if ($categories->isEmpty()) {
            throw new Exception('categories were not created');
        }
        $categoryIds = [];

        $collectCategoryIds = function (ProductCategory $category) use (&$categoryIds, &$collectCategoryIds) {
            $categoryIds[] = $category->id;
            foreach ($category->children as $childCategory) {
                $collectCategoryIds($childCategory);
            }
        };

        foreach ($categories as $category) {
            $collectCategoryIds($category);
        }

        return Product::query()->whereIn('product_category_id', $categoryIds);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
