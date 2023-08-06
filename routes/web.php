<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController; // Ditambahkan
//use App\Http\Controllers\Task;


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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::prefix('tasks')
  ->name('tasks.')
  ->controller(TaskController::class)
  ->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::get('create', 'create')->name('create');
    Route::post('/', 'store')->name('store');  // Ditambahkan
    Route::put('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
    Route::delete('/{id}/destroy', 'destroy')->name('destroy');

    // Tambahkan route untuk /progress
    Route::get('progress', 'progress')->name('progress');
    // Tambahkan route untuk /move
    Route::patch('{id}/move', 'move')->name('move');
    Route::post('{id}/completed','completed')->name('completed');
  });

Route::name('auth.')
  ->controller(AuthController::class)
  ->group(function () {
    Route::get('signup', 'signupForm')->name('signupForm');
    Route::post('signup', 'signup')->name('signup');
    // Tambahkan route-route di bawah
    Route::get('login', 'loginForm')->name('loginForm');
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->name('logout'); // Ditambahkan
  });
