<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ArticleController;
use \App\Http\Controllers\PageController;
use \App\Http\Controllers\ScorecardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getallarticles', [ArticleController::class,'getallarticles'])->name('getallarticles');
Route::apiResource('articles', ArticleController::class);
Route::apiResource('pages', PageController::class);
Route::get('/pixbayphoto/{keyword}', [PageController::class,'getPixbayPhoto'])->name('pixbayphoto');
Route::get('/articles/category/{category}', [ArticleController::class,'getArtcilesByCategory'])->name('getArtcilesByCategory');


Route::post('/getarticles', [ArticleController::class,'getarticles'])->name('getarticles');
Route::post('/addfavarticle', [ArticleController::class,'addFavourite'])->name('addfavarticle');
Route::post('/unfavarticle', [ArticleController::class,'deleteFavourite'])->name('unfavarticle');
Route::post('/getfavourites', [ArticleController::class,'getUserFavourites'])->name('getfavourites');
Route::post('/getarticlewithfav', [ArticleController::class,'getArticleWithFav'])->name('getarticlewithfav');
Route::post('/searcharticle', [ArticleController::class,'search'])->name('searcharticle');
Route::post('/getscore', [ScorecardController::class,'getscore'])->name('getscore');