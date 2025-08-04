<?php

use App\Http\Controllers\backend\admin\DashboardController;
use App\Http\Controllers\backend\admin\ProfileController;
use App\Http\Controllers\backend\admin\SalesmanController;
use App\Http\Controllers\backend\AuthenticationController;
use App\Http\Controllers\backend\ChatController;
use App\Http\Controllers\backend\salesman\DashboardController as SalesmanDashboardController;
use App\Http\Controllers\backend\salesman\ProfileController as SalesmanProfileController;
use App\Http\Controllers\FrontEndController;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\Salesman;
use App\Http\Middleware\SalesmanAuthenticationMiddleware;
use Illuminate\Support\Facades\Route;

// frontend 

Route::get('/', [FrontEndController::class, 'home'])->name('home');


// backend 
Route::match(['get', 'post'], 'login', [AuthenticationController::class, 'login'])->name('login');
// route prefix 
Route::prefix('admin')->group(function () {
    // route name prefix 
    Route::name('admin.')->group(function () {
        //middleware 
        Route::middleware(AdminAuthenticationMiddleware::class)->group(function () {
            Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
            //profile 
            Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
            Route::post('profile-info/update', [ProfileController::class, 'profile_info_update'])->name('profile.info.update');
            Route::post('profile-password/update', [ProfileController::class, 'profile_password_update'])->name('profile.password.update');
            //dashboard
            Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

            Route::match(['get', 'post'], 'salesman/add', [SalesmanController::class, 'salesman_add'])->name('salesman.add');
            Route::get('salesman/list', [SalesmanController::class, 'salesman_list'])->name('salesman.list');
            Route::match(['get', 'post'], 'salesman/edit/{id}', [SalesmanController::class, 'salesman_edit'])->name('salesman.edit');
            Route::get('salesman/delete/{id}',[SalesmanController::class,'salesman_delete'])->name('salesman.delete');


             Route::get('chat/{receiver_id}', [ChatController::class, 'chatWith'])->name('chat');
        });
    });
});
// Advocate 
// route prefix
Route::prefix('salesman')->group(function () {
    // route name prefix
    Route::name('salesman.')->group(function () {
        //middleware 
            Route::middleware(SalesmanAuthenticationMiddleware::class)->group(function () {
            Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
            //profile 
            Route::get('profile', [SalesmanProfileController::class, 'profile'])->name('profile');
            Route::post('profile-info/update', [SalesmanProfileController::class, 'profile_info_update'])->name('profile.info.update');
            Route::post('profile-password/update', [SalesmanProfileController::class, 'profile_password_update'])->name('profile.password.update');
            //dashboard 
            Route::get('dashboard', [SalesmanDashboardController::class, 'dashboard'])->name('dashboard');

             Route::get('chat/{receiver_id}', [ChatController::class, 'chatWith'])->name('chat');
        });
    });
});
