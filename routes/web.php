<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", [\App\Http\Controllers\HomeController::class, "home"]);

Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
    Route::get('/login', 'login')->middleware([\App\Http\Middleware\OnlyGuestMiddleWare::class]);
    Route::post('/login', 'onLogin')->middleware([\App\Http\Middleware\OnlyGuestMiddleWare::class]);
    Route::post('/logout', 'onLogout')->middleware([\App\Http\Middleware\OnlyMemberMiddleware::class]);
});

Route::middleware([\App\Http\Middleware\OnlyMemberMiddleware::class])->group(function () {
    Route::get('/todolist', [\App\Http\Controllers\TodolistController::class, "index"])->name("todolist.index");
    Route::post('/todolist', [\App\Http\Controllers\TodolistController::class, "store"])->name("todolist.store");
    Route::delete('/todolist/{id}', [\App\Http\Controllers\TodolistController::class, "destroy"])->name("todolist.destroy");
    Route::patch('/todolist/{id}/complete', [\App\Http\Controllers\TodolistController::class, "complete"])->name("todolist.complete");
})->middleware([\App\Http\Middleware\OnlyMemberMiddleware::class]);
