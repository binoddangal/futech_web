<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Front\Home\HomeController::class,'index'])->name('home');
Route::get('service', [\App\Http\Controllers\Front\Home\HomeController::class,'service'])->name('service');
Route::get('blog', [\App\Http\Controllers\Front\Home\HomeController::class,'blog'])->name('blog');
Route::get('blog/{slug}', [\App\Http\Controllers\Front\Home\HomeController::class,'blogDetails'])->name('blog.detail');
Route::get('about-us', [\App\Http\Controllers\Front\Home\HomeController::class,'about'])->name('about');
Route::get('contact', [\App\Http\Controllers\Front\Home\HomeController::class,'contact'])->name('contact');
