<?php

use App\Http\Controllers\Admin\AccessController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\ManageAdminController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\OfferController as UserOfferController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\PaymobController;
use App\Http\Controllers\User\UserController as UserUserController;
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
########################/*Admin Module*/##########################
Route::post('admin/login', [AccessController::class, 'login']);
Route::middleware('access')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::controller(ContactUsController::class)->group(function () {
            Route::get('all_messages', 'allMessages')->withoutMiddleware('access');
            Route::post('delete_message', 'deleteMessage');
        });
        ##########/*Category Module*/##########
        ROute::controller(CategoryController::class)->group(function () {
            Route::post('add_category', 'addCategory');
            Route::get('all_categories', 'allCategories')->withoutMiddleware('access');
            Route::post('delete_category', 'deleteCategory');
        });
        ##########/*Product Module*/##########
        Route::controller(ProductController::class)->group(function () {
            Route::post('add_product', 'store');
            Route::get('all_products', 'allProducts')->withoutMiddleware('access');
            Route::get('show_product/{id}', 'showProductWithCategory')->withoutMiddleware('access');
            Route::post('update_product', 'updateProduct');
            Route::post('delete_product', 'deleteProduct');
        });
        #########/*Offers Module*/#########
        Route::controller(OfferController::class)->group(function () {
            Route::post('add_offer', 'addOffer');
            Route::post('update_offer', 'updateOffer');
            Route::get('all_offers', 'allOffers')->withoutMiddleware('access');
            Route::get('delete_offer/{id}', 'deleteOffer')->withoutMiddleware('access');
            Route::get('show_offer/{id}', 'showOffer')->withoutMiddleware('access');
        });
        Route::get('all_users', [UserController::class, 'allUsers'])->withoutMiddleware('access');
        #########/*Orders Module*/#########
        Route::controller(AdminOrderController::class)->group(function () {
            Route::get('cash_orders', 'cashOrders')->withoutMiddleware('access');
            Route::post('accept_order', 'acceptOrder');
            Route::post('reject_order', 'rejectOrder');
            Route::get('paid_orders', 'paidOrders')->withoutMiddleware('access');
        });
        #########/*Admins Module*/#########
        Route::controller(ManageAdminController::class)->group(function () {
            Route::post('add_admin', 'addAdmin');
            Route::get('all_admins', 'allAdmins')->withoutMiddleware('access');
            Route::post('delete_admin', 'deleteAdmin');
            Route::post('update_data', 'updateData')->withoutMiddleware('access');
        });
    });
});
########################/*User Module*/##########################
Route::prefix('user')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
    ###################/*Paymob Module*/########################
    Route::controller(PaymobController::class)->group(function () {
        Route::get('state', 'responseCallback');
        Route::post('pay_details', 'payDetails');
    });
    ###############User Controller#################
    Route::controller(UserUserController::class)->group(function () {
        Route::get('home', 'index');
        Route::get('products', 'allProducts');
        Route::post('update', 'updateData')->middleware('auth:sanctum');
        Route::post('Contact_Us', 'contactUs');
        Route::get('show_product/{id}', 'showProduct');
    });
    ###############Order Controller################
    Route::controller(OrderController::class)->group(function () {
        Route::get('all_orders', 'allOrders')->middleware('auth:sanctum');
        Route::post('make_order', 'makeOrder')->middleware("auth:sanctum");
    });
    ##############Offer Controller#################
    Route::controller(UserOfferController::class)->group(function () {
        Route::get('all_offers', 'allOffers');
    });
});