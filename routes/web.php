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

Route::get('/', 'GuestController@index');

Auth::routes();
Broadcast::routes();
Route::get('/user','HomeController@show')->middleware('auth');

//Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


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
Route::post('/user/editContactData','LandlordController@update')->middleware('auth');
Route::get('/chat/{user}','ChatController@index')->middleware('auth');
Route::get('/user/fetchmessages/{user}','ChatController@show')->middleware('auth');
Route::post('/user/sendMessage','ChatController@store')->middleware('auth');
Route::get('/recipient/{user}','ChatController@findRecipient')->middleware('auth');
Route::middleware('auth')->post('user/{user}/online', 'UserOnlineController');
Route::middleware('auth')->post('user/{user}/offline', 'UserOfflineController');
Route::get('/user/fetchContactData','ContactsController@show')->middleware('auth');
Route::get('user/api/notifications/unread','ContactsController@notice')->middleware('auth');
Route::post('/user/api/notifications/markAsRead','ContactsController@updateNotice')->middleware('auth');
Route::get('/user/api/notifications/fetchallNotifications','ContactsController@loadAllNotifications')->middleware('auth');
Route::get('/chat/contact_landlord/intent/{house}','ChatController@initchat')->middleware('auth');


// Asssist routes
Route::post('/user/get/help/home', 'GuestController@assitant');

