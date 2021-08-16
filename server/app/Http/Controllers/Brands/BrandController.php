<?php

namespace App\Http\Controllers\Brands;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\CreateBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Http\Resources\Brands\BrandResource;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BrandController extends Controller
{
    public function index()
    {
        return BrandResource::collection(Brand::all());
    }

    public function store(CreateBrandRequest $request)
    {
        $data = [
            'name' => $request->name,
            'isPublished' => auth()->user()->hasRole(User::ROLES['SUPER_ADMIN']) ? ($request->has('isPublished') ? $request->isPublished : true) : false
        ];

        $brand = Brand::create($data);

        return (new BrandResource($brand))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Brand $brand)
    {
        return (new BrandResource($brand))->response()->setStatusCode(Response::HTTP_OK);
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $data = $request->only('name');
        $data += ['isPublished' => $request->has('isPublished') ? $request->isPublished : $brand->isPublished];

        $brand->update($data);

        return (new BrandResource($brand))->response()->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
