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

// ROTTE PUBBLICHE
Route::group(['prefix' => '/'], function() {
    Route::get('/', function () {return view('welcome');})->name('home');
});

// ROTTE APP CON UTENTE LOGATO
Route::group(['middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified']], function() {
    Route::get('/dashboard', function () { return view('dashboard');})->name('dashboard');
});

// ROTTE ADMIN
Route::group(['prefix' => config('routes.admin-prefix-url'), 'middleware' => ['auth:sanctum', 'verified', 'admin']], function () {
    Route::get('/users_manager/users', function () { return view('admin.user-manager.users');})->name('admin.users_manager.users');
    Route::get('/users_manager/roles', function () { return view('admin.user-manager.roles');})->name('admin.users_manager.roles');
    Route::get('/users_manager/permissions', function () { return view('admin.user-manager.permissions');})->name('admin.users_manager.permissions');

    Route::group(['prefix' => 'tools'], function () {
        Route::get('/logs_viewer', function () { return view('admin.tools.logs-viewer');})->name('admin.tools.logs_viewer');
    });
});
