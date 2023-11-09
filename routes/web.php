<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContestController;
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
    dd(123);
    return view('welcome');
});


Route::get('/contests',[ContestController::class, 'index'])->name('contests.index');
Route::get('/contests/create',[ContestController::class, 'create'])->name('contests.create');
Route::post('/contests',[ContestController::class, 'store'])->name('contests.store');
Route::get('/contests/{contests}/edit',[ContestController::class, 'edit'])->name('contests.edit');
Route::put('/contests/{contests}/update',[ContestController::class, 'update'])->name('contests.update');
Route::delete('/contests/{contests}/delete',[ContestController::class, 'delete'])->name('contests.delete');