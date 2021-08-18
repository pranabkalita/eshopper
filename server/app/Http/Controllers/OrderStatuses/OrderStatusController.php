<?php

namespace App\Http\Controllers\OrderStatuses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Http\Requests\OrderStatuses\CreateOrderStatusRequest;
use App\Http\Resources\OrderStatuses\OrderStatusResource;
use Symfony\Component\HttpFoundation\Response;

class OrderStatusController extends Controller
{
    public function store(CreateOrderStatusRequest $request)
    {
        $orderStatuses = Order::findOrFail($request->order_id)->orderStatuses()->create(['status' => $request->status]);

        return (new OrderStatusResource($orderStatuses))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
