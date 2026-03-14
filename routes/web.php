<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('dashboard',[adminController::class,'dashboard'])->name('dashboard');
Route::get('register',[AuthController::class,'showRegister'])->name('register');
Route::get('analytics',[adminController::class,'analytics'])->name('analytics');
Route::get('login',[AuthController::class,'showLogin'])->name('login');
Route::get('workstation',[adminController::class,'workstation'])->name('workstation');
Route::view('/workstation/pc1',[adminController::class,'workstation_view'])->name('pc1');
