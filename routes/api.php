<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//user routes
Route::post('/register','authController@register');
Route::post('/login','authController@login');
Route::get('/users', 'authController@show');
Route::get('/edit-user/{id}', 'authController@edit');

//project routes
Route::post('/addProject', 'ProjectController@addProject');
Route::get('/deleteProject/{id}', 'ProjectController@deleteProject');
Route::post('/editProject/{id}', 'ProjectController@edit');
Route::get('/project/{id}', 'ProjectController@getProjectById');
Route::get('/userProjects/{id}','ProjectController@getUserProjects');


