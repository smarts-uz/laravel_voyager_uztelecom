<?php

use App\Http\Controllers\Site\ApplicationController;
use App\Http\Controllers\Site\DashboardController;
use App\Http\Controllers\Site\ProfileController;
use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
    return redirect()->route('site.applications.create');
});

Route::group([
    'prefix' => 'admin',
    'middleware' => 'isAdmin'
], function () {
    Voyager::routes();


});
Route::get('admin/login', [LoginController::class, 'login'])->name('voyager.login');
Route::post('admin/login', [LoginController::class, 'postLogin'])->name('voyager.login');

Auth::routes();

Route::post('eimzo/login', [\Asadbek\Eimzo\Http\Controllers\EimzoController::class, 'auth'])->name('eri.login');

Route::group([
    'prefix' => LaravelLocalization::setLocale()
], function()
{
    Route::group(
        [
            'as' => 'site.',
            'prefix' => 'site',
            'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]

        ],

        function(){
            Route::group(
                [
                    'as' => 'profile.',
                    'prefix' => 'profile',
                ],
                function(){
                    Route::get('', [ProfileController::class, 'index'])->name('index');
                    Route::put('update', [ProfileController::class, 'update'])->name('update');
                });
            Route::group(
                [
                    'as' => 'applications.',
                    'prefix' => 'applications',
                ],
                function(){
                    Route::get('', [ApplicationController::class, 'index'])->name('index');
                    Route::get('list', [ApplicationController::class, 'getdata'])->name('list');
                    Route::get('{application}/show', [ApplicationController::class, 'show'])->name('show');
                    Route::get('{application}/edit', [ApplicationController::class, 'edit'])->name('edit');
                    Route::post('{application}/update', [ApplicationController::class, 'update'])->name('update');
                    Route::get('create', [ApplicationController::class, 'create'])->name('create');
                    Route::post('store', [ApplicationController::class, 'store'])->name('store');
                    Route::post('form', [ApplicationController::class, 'form'])->name('form');
                    Route::get('getAll', [ApplicationController::class, 'getAll'])->name('getAll');
                });
            Route::group(
                [
                    'as' => 'faqs.',
                    'prefix' => 'faqs',
                ],
                function(){
                    Route::get('', [ApplicationController::class, 'index'])->name('index');
                    
                    Route::get('{faq}/show', [ApplicationController::class, 'show'])->name('show');
                    Route::get('{faq}/edit', [ApplicationController::class, 'edit'])->name('edit');
                    Route::post('{faq}/update', [ApplicationController::class, 'update'])->name('update');
                    Route::get('create', [ApplicationController::class, 'create'])->name('create');
                    Route::post('{application}/store', [ApplicationController::class, 'store'])->name('store');
                    Route::post('form', [ApplicationController::class, 'form'])->name('form');
                    Route::get('getAll', [ApplicationController::class, 'getAll'])->name('getAll');
                });
            Route::group(
                [
                    'as' => 'dashboard.',
                    'prefix' => 'dashboard'
                ],
                function(){
                    Route::get('index', [DashboardController::class, 'index'])->name('index');

                });
        }
    );

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test/{id}', [App\Http\Controllers\Controller::class, 'test']);

Route::get('/layout', function () {
    return view('site.auth.layout');
});

Route::get('/profile', function () {
    return view('site.profile.profile');
});
Route::get('/faq/index', function () {
    return view('site.faq.index');
});
Route::get('/faq/show', function () {
    return view('site.faq.show');
});
