<?php

use App\Http\Controllers\Addresses\AddressController;
use App\Http\Controllers\Brands\BrandController;
use App\Http\Controllers\Categories\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Stocks\StockController;
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
Route::apiResource('/products', ProductController::class)->only('index', 'show');


// SFORTIFY: User Sanctum as Auth Middleware for APIs
Route::group(['middleware' => ['auth:sanctum']], function () use ($roles) {

    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });

    // Route::group(['middleware' => ["role:{$roles['SUPER_ADMIN']}"]], function () {

    //     Route::apiResource('/users', UserController::class);
    //     Route::apiResource('/categories', CategoryController::class);
    //     Route::apiResource('/brands', BrandController::class);

    // });

    // Route::group(['middleware' => ["role:{$roles['ADMIN']}"]], function () {

    //     Route::apiResource('/categories', CategoryController::class)->only('index', 'store');
    //     Route::apiResource('/brands', BrandController::class)->only('index', 'store');

    // });

    // Route::group(['middleware' => ["role:{$roles['SELLER']}|{$roles['ADMIN']}|{$roles['SUPER_ADMIN']}"]], function () {

    //     Route::apiResource('/products', ProductController::class);
    //     Route::apiResource('/images', UserController::class);
    //     Route::apiResource('/stocks', StockController::class);

    // });

    // Route::group(['middleware' => ["role:{$roles['SUPER_ADMIN']}|{$roles['ADMIN']}|{$roles['USER']}"]], function () {

    //     Route::apiResource('/addresses', AddressController::class);

    // });

    // Route::group(['middleware' => ["role:{$roles['USER']}"]], function () {

    //     Route::apiResource('/orders', OrderController::class);
    //     Route::apiResource('/reviews', UserController::class);

    // });

    Route::get('/users', [UserController::class, 'index'])->middleware('role:Super Admin|Admin');
    Route::post('/users', [UserController::class, 'store'])->middleware('role:Super Admin');
    Route::get('/users/{user}', [UserController::class, 'show'])->middleware('role:Super Admin|Admin');
    Route::put('/users/{user}', [UserController::class, 'update'])->middleware('role:Super Admin');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('role:Super Admin');

    Route::get('/categories', [CategoryController::class, 'index'])->middleware('role:Super Admin|Admin|Seller|User');
    Route::post('/categories', [CategoryController::class, 'store'])->middleware('role:Super Admin|Admin');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->middleware('role:Super Admin|Admin|Seller|User');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->middleware('role:Super Admin|Admin');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->middleware('role:Super Admin');

    Route::get('/brands', [BrandController::class, 'index'])->middleware('role:Super Admin|Admin|Seller|User');
    Route::post('/brands', [BrandController::class, 'store'])->middleware('role:Super Admin|Admin');
    Route::get('/brands/{brand}', [BrandController::class, 'show'])->middleware('role:Super Admin|Admin|Seller|User');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->middleware('role:Super Admin|Admin');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->middleware('role:Super Admin');

    Route::get('/products', [ProductController::class, 'index'])->middleware('role:Super Admin|Admin|Seller');
    Route::post('/products', [ProductController::class, 'store'])->middleware('role:Super Admin|Admin|Seller');
    Route::get('/products/{product}', [ProductController::class, 'show'])->middleware('role:Super Admin|Admin|Seller');
    Route::put('/products/{product}', [ProductController::class, 'update'])->middleware('role:Super Admin|Admin|Seller');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->middleware('role:Super Admin|Admin|Seller');

    Route::get('/stocks', [StockController::class, 'index'])->middleware('role:Super Admin|Admin|Seller');
    Route::post('/stocks', [StockController::class, 'store'])->middleware('role:Super Admin|Admin|Seller');
    Route::get('/stocks/{stock}', [StockController::class, 'show'])->middleware('role:Super Admin|Admin|Seller');
    Route::put('/stocks/{stock}', [StockController::class, 'update'])->middleware('role:Super Admin|Admin|Seller');
    Route::delete('/stocks/{stock}', [StockController::class, 'destroy'])->middleware('role:Super Admin|Admin|Seller');

    Route::get('/addresses', [AddressController::class, 'index'])->middleware('role:Super Admin|Admin|User');
    Route::post('/addresses', [AddressController::class, 'store'])->middleware('role:User');
    Route::get('/addresses/{address}', [AddressController::class, 'show'])->middleware('role:User');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->middleware('role:User');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->middleware('role:User');

    Route::get('/orders', [OrderController::class, 'index'])->middleware('role:Super Admin|Admin|User');
    Route::post('/orders', [OrderController::class, 'store'])->middleware('role:User');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->middleware('role:User');


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
