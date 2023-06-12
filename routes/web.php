<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use \App\Http\Controllers\PageController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\LinkedinController;
use App\Http\Controllers\PointController;
use Laravel\Socialite\Facades\Socialite;

//Enforce HTTPS Routes
if (App::environment('production')) {
    URL::forceScheme('https');
}

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
//Public Routes
Route::get('/', [PageController::class,'welcome'])->name('welcome');
Route::inertia('/articles', 'Articles');
Route::get('/articles/{articleid}', [PageController::class,'showarticles'])->name('showarticles');

Route::inertia('/processes', 'Processes');
Route::inertia('/bankingwords', 'BankingWords');
Route::inertia('/rates', 'Rates');
Route::inertia('/loans', 'Loans');

Route::post('/updatesession', [PageController::class,'updatesession'])->name('updatesession');

Route::get('/updrates', [PageController::class,'updaterates'])->name('updrates');
Route::get('/updexrates', [PageController::class,'updateExchangeRates'])->name('updexrates');

//Authenticated Routes
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => 'auth','verified'],function(){
    Route::get('pointpage',[PointController::class,'pointpage'])->name('point#page');
});

Route::get('/favourites', function () {
    return Inertia::render('Favourites');
})->middleware(['auth', 'verified'])->name('favourites');

Route::get('/checkscore', function () {
    return Inertia::render('CheckScore');
})->middleware(['auth', 'verified'])->name('checkscore');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

if (App::environment('local')) {
    Route::get('/setup/{bucketno}', [ArticleController::class,'setup'])->name('setup');
    Route::get('/setuppages', [ArticleController::class,'setupPages'])->name('setuppages');
}

Route::get('/auth/linkedin/redirect', [LinkedinController::class, 'handleRedirect'])->name('linkedin.redirect');
Route::get('/auth/linkedin/callback', [LinkedinController::class, 'handleCallback'])->name('linkedin.callback');

require __DIR__.'/auth.php';