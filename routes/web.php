<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TimelogController;
use App\Http\Controllers\UserController;
use App\Livewire\CustomerEdit;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function() {

    Route::view('/', 'layouts.app')->name('app');

    Route::get('customers/{customer}/invoice',
        [InvoiceController::class, 'create'])->name('invoice.create');


    Route::post('customers/{customer}/contracts',
        [\App\Models\Customer::class, 'store'])->name('customer.contracts.store');
    Route::delete('customers/{customer}/contracts{contract}',
        [CustomerController::class, 'destroy'])->name('customer.contracts.destroy');


    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('customers/{customer}/edit', CustomerEdit::class)->name('customers.edit');
    // Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    Route::resources([
        'users'     => UserController::class,
        'services'  => ServiceController::class,
        'contracts' => ContractController::class,
        'timelogs'  => TimelogController::class,
    ]);

});

// Auth
Route::get('/register', [UserController::class, 'create'])->name('register_create')->middleware('guest');
Route::post('/register', [UserController::class, 'store'])->name('register_store')->middleware('guest');

Route::get('/login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->middleware('guest');
Route::post('/logout', [SessionController::class, 'destroy']);