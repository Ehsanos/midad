<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\API\OrdersController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\UserController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


Route::post('register', [RegisteredUserController::class, 'store']);


// not auth requests
Route::middleware('guest')->group(function () {
    // 1) Register

    // 2) Login
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // 3) Get Products


});

// auth requests
Route::middleware('auth:sanctum')->group(function () {

    Route::get('all-users', [UserController::class, 'index']);//all users in DB

    Route::post('/add-user', [UserController::class, 'store']); //Add new User


//    Route::get('/products', [ProductsController::class, 'index']); //get All Products in DB

    Route::post('/add-product', [ProductsController::class, 'store']);

    Route::put('/edit-product/{id}', [ProductsController::class, 'update']);

    Route::get('/cats', [ProductsController::class, 'GetCategories']); //Get All Cats in DB

    Route::post('add-cat', [CategoryController::class, 'addCat']);






    Route::get('products', [ProductsController::class, 'GetProducts']);

    // 4) Get Categories
    Route::get('categories', [ProductsController::class, 'GetCategories']);




    Route::get('orders', [OrdersController::class, 'index']);


    Route::get('test', [OrdersController::class, 'index']);


    Route::get('/info', [ProductsController::class, 'info']);



    //destroy cat

    Route::post('/cat-del/{id}', [CategoryController::class, 'destroy']);
    // 3) Get orders

    Route::get('/all-orders', [OrdersController::class, 'all']);

    // 4) Modify/Update Order
    Route::put('orders', [OrdersController::class, 'update']);

    //Edit Cat
    Route::put('/edit-cat/{id}', [CategoryController::class, 'edit']);

    // 5) Logout User
    Route::put('logout', [AuthenticatedSessionController::class, 'logout']);
});
