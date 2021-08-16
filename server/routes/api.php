<?php

use App\Http\Controllers\Brands\BrandController;
use App\Http\Controllers\Categories\CategoryController;
use App\Http\Controllers\Users\UserController;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$roles = User::ROLES;

// Public APIs
Route::apiResource('/categories', BrandController::class)->only('index', 'show');
Route::apiResource('/brands', BrandController::class)->only('index', 'show');


// SFORTIFY: User Sanctum as Auth Middleware for APIs
Route::group(['middleware' => ['auth:sanctum']], function () use ($roles) {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['middleware' => ["role:{$roles['SUPER_ADMIN']}"]], function () {

        Route::apiResource('/users', UserController::class);
        Route::apiResource('/categories', CategoryController::class)->only('store', 'update', 'destroy');
        Route::apiResource('/brands', BrandController::class)->only('store', 'update', 'destroy');

    });

    Route::group(['middleware' => ["role:{$roles['ADMIN']}|{$roles['SUPER_ADMIN']}"]], function () {

        Route::apiResource('/categories', CategoryController::class)->only('store');
        Route::apiResource('/brands', BrandController::class)->only('store');

    });

    Route::group(['middleware' => ["role:{$roles['SELLER']}|{$roles['ADMIN']}|{$roles['SUPER_ADMIN']}"]], function () {

        Route::apiResource('/products', UserController::class);
        Route::apiResource('/stocks', UserController::class);
        Route::apiResource('/images', UserController::class);

    });

    Route::group(['middleware' => ["role:{$roles['USER']}"]], function () {

        Route::apiResource('/orders', UserController::class);
        Route::apiResource('/addresses', UserController::class);
        Route::apiResource('/reviews', UserController::class);

    });

    // User CRUD (Super Admin Only)
    // Category CRUD (Super Admin Only)
        // Create/Update (Admin But Approve Super Admin)

    // Brands CRUD (Super Admin Only)
        // Create/Update (Admin But Approve Super Admin)

    // Product CRUD (Seller Only) (Admin/Super Admin can but have to select user for it from dropdown)
    // Stock CRUD (Seller Only) (Admin/Super Admin can but have to select user&product for it from dropdown)
    // Images CRUD (Seller Only) (Admin/Super Admin can but have to select user&product for it from dropdown)

    // Order CRUD (User Only) (Admin/Super Admin can but have to select user&product for it from dropdown)
        // Seller (Owner of the product can update the status.)
    // Address CRUD (User Only) (Admin/Super Admin can but have to select user&product for it from dropdown)

    // Reviews CRUD (User Only) (Admin & Super Admin can Approve)

});
