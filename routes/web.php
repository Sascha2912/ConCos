<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TimelogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::resources([
    'users' => UserController::class,
    'customers' => CustomerController::class,
    'services' => ServiceController::class,
    'contracts' => ContractController::class,
    'timelogs' => TimelogController::class,
]);
