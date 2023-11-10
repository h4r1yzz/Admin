<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\LiveStreaming\GetContestListController;
use App\Http\Controllers\LiveStreaming\CreateContestController;
use App\Http\Controllers\LiveStreaming\StoreContestController;
use App\Http\Controllers\LiveStreaming\EditContestController;
use App\Http\Controllers\LiveStreaming\DeleteContestController;
//use App\Http\Controllers\EditContestController;
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
Route::prefix('contests')->group(function () {
    Route::get('/', [GetContestListController::class, 'display'])->name('contests.post');
    Route::get('/create', [CreateContestController::class, 'create'])->name('contests.create');
    Route::post('/store', [StoreContestController::class, 'store'])->name('contests.store');
    Route::get('/{id}/edit', [EditContestController::class, 'edit'])->name('contests.edit');
    Route::put('/{id}/update', [EditContestController::class, 'update'])->name('contests.update');
    Route::delete('/{id}/delete', [DeleteContestController::class, 'delete'])->name('contests.delete');
});


/*Route::get('/', function () {
    dd(123);

    return view('welcome');
});*/
