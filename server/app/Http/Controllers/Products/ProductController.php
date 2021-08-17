<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\CreateProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Http\Resources\Products\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('brand', 'category', 'images')->get();

        return ProductResource::collection($products);
    }

    public function store(CreateProductRequest $request)
    {

        $data = $request->only('name', 'description', 'category_id', 'brand_id', 'price');
        $data = $data + [
            'isPublished' => $request->has('isPublished') ? $request->isPublished : true,
            'isPromoted' => $request->has('isPromoted') ? $request->isPromoted : false,
        ];

        if (auth()->user()->hasRole(User::ROLES['SUPER_ADMIN'])) {
            $data['user_id'] = $request->user_id;
            $product = Product::create($data);
        } else {
            $product = auth()->user()->products()->create($data);
        }

        $imageFiles = $this->uploadFiles($request, $product);
        if (count($imageFiles) > 0) {
            $product->images()->insert($imageFiles);
        }

        return (new ProductResource($product))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Product $product)
    {
        $product->load('brand', 'category', 'images');

        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = [
            'name' => $request->has('name') ? $request->name : $product->name,
            'description' => $request->has('description') ? $request->description : $product->description,
            'brand_id' => $request->has('brand_id') ? $request->brand_id : $product->brand_id,
            'category_id' => $request->has('category_id') ? $request->category_id : $product->category_id,
            'price' => $request->has('price') ? $request->price : $product->price,
            'isPublished' => $request->has('isPublished') ? $request->isPublished : $product->isPublished,
            'isPromoted' => $request->has('isPromoted') ? $request->isPromoted : $product->isPromoted,

        ];

        if (auth()->user()->hasRole(User::ROLES['SUPER_ADMIN'])) {
            $data['user_id'] = $request->user_id;
            $product->update($data);
        } else {
            $product->update($data);
        }

        $imageFiles = $this->uploadFiles($request, $product);
        if (count($imageFiles) > 0) {
            $images = $product->images;
            $product->images()->delete();
            $images->each(function($image) {
                unlink(public_path($image->path));
            });
            $product->images()->insert($imageFiles);
        }

        return (new ProductResource($product))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function destroy(Product $product)
    {
        $images = $product->images;
        $images->each(function($image) {
            unlink(public_path($image->path));
        });
        $product->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    private function uploadFiles($request, Product $product)
    {
        $imagePaths = [];

        if ($request->has('images') && count($request->file('images')) > 0) {
            foreach($request->file('images') as $image) {
                $filename = Product::generateImageName($image);
                $image->move(public_path(Product::IMAGE_PATH), $filename);
                $path = Product::IMAGE_PATH . $filename;

                array_push($imagePaths, ['path' => $path, 'product_id' => $product->id]);
            }
        }

        return $imagePaths;
    }
}
