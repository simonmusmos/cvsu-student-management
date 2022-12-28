<?php

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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    /**
     * Home Routes
     */
    Route::group(['middleware' => ['auth']], function() {
        /**
         * Logout Routes
         */
        Route::get('/', function () {
            return redirect(route('sections.index'));
        })->name('index');
        Route::group(['prefix' => 'sections'], function() {
            Route::get('/', 'SectionController@index')->name('sections.index');
            Route::get('/create', 'SectionController@create')->name('sections.create');
            Route::post('/', 'SectionController@add')->name('sections.add');
            Route::get('/{section}', 'SectionController@edit')->name('sections.edit');
            Route::post('/{section}', 'SectionController@update')->name('sections.update');
            Route::post('/destroy/{section}', 'SectionController@destroy')->name('sections.destroy');
        });

        Route::group(['prefix' => 'students'], function() {
            Route::get('/', 'StudentController@index')->name('students.index');
            Route::get('/create', 'StudentController@create')->name('students.create');
            Route::post('/', 'StudentController@add')->name('students.add');
            Route::get('/{student}', 'StudentController@edit')->name('students.edit');
            Route::post('/{student}', 'StudentController@update')->name('students.update');
            Route::post('/destroy/{student}', 'StudentController@destroy')->name('students.destroy');
        });

        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    
});
