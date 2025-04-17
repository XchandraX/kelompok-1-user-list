<?php

use Illuminate\Support\Facades\Route;

//untuk memanggil halaman utama
Route::get('/', [\App\Http\Controllers\UserController::class, 'index']);

//secara otomatis menangani berbagai operasi CRUD seperti create, read, update, dan delete.
Route::resource('user', \App\Http\Controllers\UserController::class);