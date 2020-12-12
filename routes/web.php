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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/user','HomeController@show')->middleware('auth');

//Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

//Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::get('/contact','GuestController@contact_page');
Route::get('/landlord/myhouses','LandlordController@getHouses')->middleware(['auth','landlord']);
Route::post('/landlord/addHouse','LandlordController@create')->middleware(['auth','landlord']);
Route::post('/landlord/editHouse','LandlordController@editHouse')->middleware(['auth','landlord']);
Route::get('/app/fetchUserCordinates','ProfileController@location');
Route::get('/user/profileData','ProfileController@user');
Route::get('/landlord/gethouse_data/{house}','HouseController@show');
Route::post('/landlord/addAgent','AgentController@create')->middleware('auth');
Route::get('/landlord/myagents','AgentController@show')->middleware('auth');
Route::post('/file/upload','ProfileController@update')->middleware('auth');
Route::get('/landlord/getHouseImageData/{house}','HouseController@fetchImages')->middleware('auth');
Route::get('/json/getHouseImageData/{house}','HouseController@json')->middleware('auth');
Route::post('/app/upload','HouseController@createImages')->middleware('auth');
Route::post('/landlord/image/upload','HouseController@store')->middleware('auth');
Route::get('/new_landlord','GuestController@newLandlord');
Route::post('/landlord/new','GuestController@create_Landlord')->middleware('guest');
Route::post('/search/house','GuestController@find');
Route::get('/house/profile/{house}','GuestController@viewHouse');
Route::get('/house/viewImage/{image}','GuestController@explore');


Route::any('{slug}', 'ProfileController@index');//->where('slug', '([A-z\d-\/_.]+)?');
