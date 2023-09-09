<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Front\Home\HomeController::class,'index'])->name('home');
Route::get('/contact', [\App\Http\Controllers\Front\Home\HomeController::class,'contact'])->name('contact');
