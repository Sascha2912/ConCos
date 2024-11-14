<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TimelogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetUserLocale;

// ########## Group Routes for Authentication ##########
Route::middleware('auth')->group(function() {

// ########## Set local to Users preferred language ##########
    Route::middleware(SetUserLocale::class)->group(function() {

        // ########## Customer-Index as Homepage ##########
        Route::redirect('/', '/customers');

        // ########## User Special Routes ##########
        Route::get('/users/{user}/profile/edit',
            [UserController::class, 'edit'])->name('user.profile.edit');
        Route::put('/users/{user}/language',
            [UserController::class, 'update'])->name('users.update.language');

        // ########## Route Resources for Users, Customers, Contracts and Services ##########
        Route::resources([
            'users'     => UserController::class,
            'customers' => CustomerController::class,
            'contracts' => ContractController::class,
            'services'  => ServiceController::class,
        ]);

        // ########## Routes for Customer time logs and monthly Reports ##########
        Route::resource('customers.timelogs', TimelogController::class)->shallow();
        Route::get('/customers/{customer}/monthly-report',
            [CustomerController::class, 'show'])->name('monthly.report.show');

        // ########## Customer-Contract Routes ##########
        Route::post('customers/{customer}/contracts',
            [\App\Models\Customer::class, 'store'])->name('customer.contracts.store');
        Route::delete('customers/{customer}/contracts{contract}',
            [CustomerController::class, 'destroy'])->name('customer.contracts.destroy');
    });

});

// Auth
Route::get('/login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->name('login')->middleware('guest');
Route::post('/logout', [SessionController::class, 'destroy']);