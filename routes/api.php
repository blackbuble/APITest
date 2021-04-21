<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\Auth;
use App\Http\Middleware\Role;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ReportController;
//use App\Http\Controllers\API\MessageController;

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

/* Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    
    Route::get('userList','AuthController@getUserList');
}); */

Route::post('signup',[AuthController::class, 'signup']);
Route::post('signin',[AuthController::class, 'signin']);
Route::post('signout',[AuthController::class, 'signout']);

Route::middleware('auth:api')->group( function() {
	Route::get('user',[AuthController::class, 'user']);
	Route::get('messages/showUserMessage',[MessageController::class, 'showUserMessage']);
	Route::post('reports/sendReport',[ReportController::class, 'sendReport']);
	Route::resource('messages',MessageController::class)->except( ['create','edit'] );
	
	//Limit Access if Role is Staff by Role Middleware
	Route::middleware('admin:api')->group( function() {
		Route::get('users/erase/{id}',[UserController::class, 'erase']);
		Route::get('users/eraseAll',[UserController::class, 'eraseAll']);
		Route::get('users/restore/{id}',[UserController::class, 'restore']);
		Route::get('users/restoreAll',[UserController::class, 'restoreAll']);
		Route::get('users/trash',[UserController::class, 'trash']);
		Route::resource('users', UserController::class)->except( ['create','edit'] );
		Route::resource('reports', ReportController::class)->except( ['create','edit'] );
		
	});
	
	/* Route::middleware('customer:api')->group( function() {
		//Route::get('messages/user',[MessageController::class, 'showUserMessage']);
		Route::get('messages/showUserMessage',[MessageController::class, 'showUserMessage']);
	}); */
	
});