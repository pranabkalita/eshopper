<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\CreateOrderRequest;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{

    public function index()
    {
        if (auth()->user()->hasRole([User::ROLES['SUPER_ADMIN'], User::ROLES['ADMIN']])) {
            return OrderResource::collection(Order::paginate());
        } else {
            return OrderResource::collection(auth()->user()->orders);
        }
    }


    public function store(CreateOrderRequest $request)
    {
        $data = [
            'address_id' => $request->address_id,
            'first_name' => auth()->user()->first_name,
            'first_name' => auth()->user()->first_name,
            'email' => auth()->user()->email
        ];

        $order = auth()->user()->orders()->create($data);
        collect($request->items)->each(function($item) use ($order) {
            $order->orderDetails()->create($item);
        });

        $order->orderStatuses()->create(['status' => 'pending']);

        return (new OrderResource($order))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }
}
