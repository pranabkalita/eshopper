<?php

namespace App\Http\Resources\Stocks;

use App\Http\Resources\Products\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
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
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total' => $this->total,
            'dates' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
