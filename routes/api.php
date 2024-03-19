<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [UserAuthController::class, 'login']); //login request
Route::post('logout', [UserAuthController::class, 'logout']); //logout request
Route::post('register', [UserAuthController::class, 'register']); //add new  user
Route::get('show', [UserAuthController::class, 'showuser']); // get all users data
Route::post('delete/{id}', [UserAuthController::class, 'destroy']);// delete user by id

Route::apiResource('products', ProductController::class); // show All products
Route::apiResource('images', ImageController::class); // Show all Images

//mailer
Route::post('sendemail', [SendMailController::class, 'store']); //contact page send mail


//Subscription
Route::prefix('subscription')->group(function () {
    // subscription
    Route::controller(SubscriptionController::class)->group(function () {
        Route::get('index', 'index')->middleware('api'); //show all  subscriptions in dashboard
        Route::post('store', 'store'); //add  new subscription
    });
});

//orders
Route::prefix('orders')->group(function () {
    Route::controller(OrderController::class)->group(function () {
        Route::get('index', 'index'); // show all orders in dashboard
        Route::post('show', 'show'); // Tracking Order
        Route::post('store', 'store'); // add new order
        Route::post('update/{id}', 'update'); // update order by id
        Route::post('showsingele/{id}', 'showsingele'); // update order by id
        Route::post('delete/{id}', 'destroy'); // delete order from database  by id
    });
});

//cart
Route::prefix('cart')->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::get('list', 'cartList'); // changed 'cartList' to 'list'
        Route::post('add', 'addToCart'); // changed 'add' to 'add'
        Route::post('update/{id}', 'updateCart');
        Route::post('remove/{id}', 'removeCart');
        Route::post('clear', 'clearAllCart');
    })->middleware('api');
});
