<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('dashboard',[adminController::class,'dashboard'])->name('dashboard');
Route::get('register',[AuthController::class,'register']);
Route::get('analytics',[adminController::class,'analytics'])->name('analytics');