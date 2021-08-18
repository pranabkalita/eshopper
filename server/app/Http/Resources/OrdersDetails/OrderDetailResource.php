<?php

namespace App\Http\Resources\OrdersDetails;

use App\Http\Resources\Products\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'product' => new ProductResource($this->product),
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total' => $this->total
        ];
    }
}
