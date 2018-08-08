<?php

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
//only guests can access these routes
Route::group(['middleware' => ['guest']], function () {
    Route::post('/signup', 'UsersController@store');    
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/select-type', 'HomeController@select_type');
Route::get('/save-type/{type}', 'HomeController@save_type');

Route::get('auth/google', 'Auth\LoginController@redirectToProvider');
Route::get('auth/google/callback', 'Auth\LoginController@handleProviderCallback');
Route::resource('zeros', 'ZerosController');
Route::resource('ones', 'OnesController');
Route::resource('twos', 'TwosController');

Route::post('/phone/validation', 'ThreesController@submit_validation');
Route::resource('threes', 'ThreesController');
Route::resource('fours', 'FoursController');
Route::resource('fives', 'FivesController');
Route::resource('anonymouses', 'AnonymousesController');