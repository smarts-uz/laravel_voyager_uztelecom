<?php

use App\Http\Controllers\Site\ApplicationController;
use App\Http\Controllers\VoyagerAuthController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
//    Route::get('login', [VoyagerAuthController::class, 'login'])->name('voyager.login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/site', function () {
    return view('site.applications.index');
});


Auth::routes();

Route::group(
    [
        'as' => 'site.',
        'prefix' => 'site'
    ],
    function(){
        Route::group(
            [
                'as' => 'applications.',
                'prefix' => 'applications'
            ],
            function(){
                Route::get('', [ApplicationController::class, 'index'])->name('index');
                Route::get('show', [ApplicationController::class, 'show'])->name('show');
                Route::get('edit', [ApplicationController::class, 'edit'])->name('edit');
                Route::get('update', [ApplicationController::class, 'update'])->name('update');
                Route::get('create', [ApplicationController::class, 'create'])->name('create');
                Route::get('store', [ApplicationController::class, 'store'])->name('store');

            });
    }
);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
