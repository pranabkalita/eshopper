<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\Addresses\AddressResource;
use App\Http\Resources\OrdersDetails\OrderDetailResource;
use App\Http\Resources\OrdersStatuses\OrderStatusResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'address' => new AddressResource($this->address),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'items' => OrderDetailResource::collection($this->orderDetails),
            'status' => OrderStatusResource::collection($this->orderStatuses)
        ];
    }
}
