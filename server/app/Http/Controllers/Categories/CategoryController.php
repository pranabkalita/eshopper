<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Categoties\CategoryResource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::get());
    }

    public function store(CreateCategoryRequest $request)
    {
        $data = [
            'name' => $request->name,
            'isPublished' => auth()->user()->hasRole(User::ROLES['SUPER_ADMIN']) ? ($request->has('isPublished') ? $request->isPublished : true) : false
        ];

        $category = Category::create($data);

        return (new CategoryResource($category))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Category $category)
    {
        return (new CategoryResource($category))->response()->setStatusCode(Response::HTTP_OK);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->only('name');
        $data += ['isPublished' => $request->has('isPublished') ? $request->isPublished : $category->isPublished];

        $category->update($data);

        return (new CategoryResource($category))->response()->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
