<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\WorkstationController;
use Illuminate\Support\Facades\Route;


Route::get('/login',[AuthController::class,'index']);
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/register',[AuthController::class,'create'])->name('register');
Route::post('/register',[AuthController::class,'store'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard',[adminController::class,'dashboard'])->name('dashboard');
    Route::get('/analytics',[adminController::class,'analytics'])->name('analytics');
    // Workstation  Routes
    Route::get('/workstation',[WorkstationController::class,'index'])->name('workstation');
    Route::get('/workstation/add',[WorkstationController::class,'create'])->name('workstation.create');
    Route::get('/workstation/pc1',[adminController::class,'workstation_view'])->name('pc1');
    // Device Route
    Route::get('/device',[DeviceController::class,'index'])->name('device');
    Route::get('/device/add',[DeviceController::class,'create'])->name('device.create');
});