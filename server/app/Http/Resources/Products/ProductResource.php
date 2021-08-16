<?php

namespace App\Http\Resources\Products;

use App\Http\Resources\Brands\BrandResource;
use App\Http\Resources\Categoties\CategoryResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'slug' => $this->slug,
            'user' => new UserResource($this->user),
            'brand' => new BrandResource($this->brand),
            'category' => new CategoryResource($this->category),
            'description' => $this->description,
            'price' => $this->price,
            'isPublished' => $this->isPublished,
            'isPromoted' => $this->isPromoted,
            'images' => ImageResource::collection($this->images)
        ];
    }
}
