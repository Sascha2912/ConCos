<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TimelogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SetUserLocale;

Route::middleware('auth')->group(function() {

    Route::middleware(SetUserLocale::class)->group(function() {

        Route::redirect('/', '/customers');

        Route::resources([
            'users'    => UserController::class,
            'services' => ServiceController::class,
        ]);

        Route::get('/profile/edit', [UserController::class, 'edit'])->name('user.profile.edit');

        Route::put('/users/{user}/language', [UserController::class, 'update'])->name('users.update.language');

        Route::get('customers/{customer}/invoice',
            [InvoiceController::class, 'create'])->name('invoice.create');

        // ########## Customer Routes ##########
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/create', App\Livewire\Customers\Create::class)->name('customers.create');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::get('customers/{customer}/edit',
            App\Livewire\Customers\Edit::class)->name('customers.edit');
        Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

        // ########## Contract Routes ##########
        Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');
        Route::get('/contracts/create', App\Livewire\Contracts\Create::class)->name('contracts.create');
        Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
        Route::get('/contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');
        Route::get('contracts/{contract}/edit', App\Livewire\Contracts\Edit::class)->name('contracts.edit');
        Route::put('/contracts/{contract}', [ContractController::class, 'update'])->name('contracts.update');
        Route::delete('/contracts/{contract}', [ContractController::class, 'destroy'])->name('contracts.destroy');

        // ########## Customer-Contract Routes ##########
        Route::post('customers/{customer}/contracts',
            [\App\Models\Customer::class, 'store'])->name('customer.contracts.store');
        Route::delete('customers/{customer}/contracts{contract}',
            [CustomerController::class, 'destroy'])->name('customer.contracts.destroy');

        // ########## Timelog Routes ##########
        Route::get('/customers/{customer}/timelogs', [TimelogController::class, 'index'])->name('timelogs.index');
        Route::get('/customers/{customer}/timelogs/create',
            App\Livewire\Timelogs\Create::class)->name('timelogs.create');
        Route::post('/timelogs', [TimelogController::class, 'store'])->name('timelogs.store');
        Route::get('/timelogs/{timelog}', [TimelogController::class, 'show'])->name('timelogs.show');
        Route::get('timelogs/{timelog}/edit',
            App\Livewire\Timelogs\Edit::class)->name('timelogs.edit');
        Route::put('/timelogs/{timelog}', [TimelogController::class, 'update'])->name('timelogs.update');
        Route::delete('/timelogs/{timelog}', [TimelogController::class, 'destroy'])->name('timelogs.destroy');

    });

});

// Auth

Route::get('/login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->name('login')->middleware('guest');
Route::post('/logout', [SessionController::class, 'destroy']);