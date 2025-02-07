<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

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
    return view('welcome');
});
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/authors-top', [BookController::class, 'topAuthors'])->name('authors.top');
Route::get('/books-rate', [BookController::class, 'showRateForm'])->name('books.rate.form');
Route::post('/books-rate', [BookController::class, 'rateBook'])->name('books.rate');
