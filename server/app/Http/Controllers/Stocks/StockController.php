<?php

namespace App\Http\Controllers\Stocks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stocks\CreateStockRequest;
use App\Http\Requests\Stocks\UpdateStockRequest;
use App\Http\Resources\Stocks\StockResource;
use App\Models\Stock;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class StockController extends Controller
{
    public function index()
    {
        return StockResource::collection(Stock::with('product', 'product.brand', 'product.category', 'product.images', 'product.user')->paginate(10));
    }

    public function store(CreateStockRequest $request)
    {
        $stock = Stock::create($request->only('quantity', 'price', 'product_id'));

        return (new StockResource($stock))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Stock $stock)
    {
        $stock->load('product');

        return new StockResource($stock);
    }

    public function update(UpdateStockRequest $request, Stock $stock)
    {
        $data = [
            'product_id' => $request->has('product_id') ? $request->product_id : $stock->product_id,
            'quantity' => $request->has('quantity') ? $request->quantity : $stock->quantity,
            'price' => $request->has('price') ? $request->price : $stock->price,
        ];
        $stock->update($data);

        return (new StockResource($stock))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
