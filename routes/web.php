<?php

use App\Http\Controllers\adminController as AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\WorkstationController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;


Route::get('/login',[AuthController::class,'index']);
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/register',[AuthController::class,'create'])->name('register');
Route::post('/register',[AuthController::class,'store'])->name('register.store');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('dashboard');
    Route::get('/analytics',[AdminController::class,'analytics'])->name('analytics');
    Route::get('/reports',[AdminController::class,'reports'])->name('reports');
    // Workstation  Routes
    Route::get('/workstation',[WorkstationController::class,'index'])->name('workstation');
    Route::get('/workstation/add',[WorkstationController::class,'create'])->name('workstation.create');
    Route::get('/workstation/pc1',[AdminController::class,'workstation_view'])->name('pc1');
    // Device Route
    Route::get('/device',[DeviceController::class,'index'])->name('device');
    Route::get('/device/add',[DeviceController::class,'create'])->name('device.create');
    Route::post('/device/add',[DeviceController::class,'store'])->name('device.store');
    Route::put('/device/{device}', [DeviceController::class, 'update'])->name('device.update');
    // Account Route
    Route::get('/account',[AccountController::class,'index'])->name('account');
    Route::post('/account/send-code',[AccountController::class,'sendCode'])->name('account.send-code');
    Route::put('/account/update',[AccountController::class,'update'])->name('account.update');
    Route::delete('/account/delete',[AccountController::class,'destroy'])->name('account.delete');
});
