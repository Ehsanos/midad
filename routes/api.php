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

// 1) Register
Route::post('register', [RegisteredUserController::class, 'store']);

// 2) Login
Route::post('login', [AuthenticatedSessionController::class, 'store']);


Route::middleware('guest')->group(function () {


    // 3) Get Products


});


// auth requests
Route::middleware('auth:sanctum')->group(function () {

    Route::get('all-users', [UserController::class, 'index']);//all users in DB

    Route::post('/add-user', [UserController::class, 'store']); //Add new User


    Route::get('/products', [ProductsController::class, 'index']); //get All Products in DB

    Route::post('/add-product', [ProductsController::class, 'store']); //add new product

    Route::put('/edit-product/{id}', [ProductsController::class, 'update']); //update product

    Route::get('/cats', [ProductsController::class, 'GetCategories']); //Get All Cats in DB

    Route::post('add-cat', [CategoryController::class, 'addCat']);//add new category

//   Route::get('products', [ProductsController::class, 'GetProducts']);

    Route::get('categories', [ProductsController::class, 'GetCategories']);// Get Categories

    Route::get('orders', [OrdersController::class, 'index']); //get all orders for user

    Route::Post('orders', [OrdersController::class, 'store']); //create Order

    Route::get('/info', [ProductsController::class, 'info']); // get some information from DB

    Route::post('/cat-del/{id}', [CategoryController::class, 'destroy']);//delete category

    Route::get('/all-orders', [OrdersController::class, 'all']); //Get All orders

    Route::put('order/{id}', [OrdersController::class, 'update']); //Modify/Update Order

    Route::put('/edit-cat/{id}', [CategoryController::class, 'edit']); //Edit Category

    Route::put('logout', [AuthenticatedSessionController::class, 'logout']);//Logout User

});
