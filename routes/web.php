<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\EmployeesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();

Route::get('/home', [EmployeesController::class, 'index'])->name('home');
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('positions', PositionsController::class);
    Route::get('positions/showToDestroy/{id}', [PositionsController::class, 'showToDestroy'])->name('showToDestroy');
    Route::resource('employees', EmployeesController::class);
    Route::get('employees/showToDestroy/{id}', [EmployeesController::class, 'showToDestroy']);
    Route::get('autocomplete', [EmployeesController::class, 'autocomplete'])->name('autocomplete');
});

