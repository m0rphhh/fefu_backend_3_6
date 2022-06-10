<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryWithProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = $this->products()->paginate(2);
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'parentId' => $this->parent_id,
            'products' => ProductListResource::collection($data)->response()->getData(true)
        ];
    }
}
