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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::match(['get', 'post'], '/lodges', 'LodgeController@index')->name('lodges');

Route::match(['get', 'post'], '/lodges/all', 'LodgeController@all')->name('lodges.all');

Route::get('/lodges/{lodge}', 'LodgeController@show')->name('lodges.show');

Route::get('/metro-station/all', 'MetroStationController@all')->name('metro-station.all');

Route::get('/meta/metro-main', 'MetaController@metroMain');

Route::get('/meta/metro', 'MetaController@metro');

Route::post('/deploy', function (Request $request, \App\Services\DeployService $deployService) {
    $repository = $request->input('repository');
    return $deployService->run($repository['uuid']);
});
