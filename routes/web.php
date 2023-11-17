<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentControler;
use App\Http\Controllers\CommentController;

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

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::controller(ArticleController::class)->group(function () {
        Route::get('/home', 'index')->name('home');

        Route::prefix('articles')->group(function () {
            Route::get('/create',  'create')->name('articles.create');
            Route::post('/create',  'store')->name('articles.store');

            Route::post('/change',  'changeVisibility')->name('articles.change');


            Route::get('/{id}/detail',  'show')->name('articles.show');
            Route::post('/{id}/update',  'update')->name('articles.update');
            Route::get('/{id}/edit',  'edit')->name('articles.edit');
            Route::delete('/{id}/destroy',  'destroy')->name('articles.destroy');
        });
        Route::controller(CommentController::class)->group(function () {
            Route::post('/{id}/comment', 'create')->name('articles.comment.add');
        });
    });
});
