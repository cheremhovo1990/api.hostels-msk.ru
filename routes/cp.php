<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 27.10.18
 * Time: 17:53
 */

use Illuminate\Support\Facades\Route;


Route::resource('lodges', 'LodgeController');
Route::resource('meta', 'MetaController');

Route::prefix('organizations/details')->name('details.')->group(function () {
    Route::get('/', 'DetailController@index')->name('index');
    Route::get('{detail}/create', 'DetailController@create')->name('create');
    Route::post('{detail}', 'DetailController@store')->name('store');
    Route::get('{detail}/edit', 'DetailController@edit')->name('edit');
    Route::delete('{detail}', 'DetailController@destroy')->name('destroy');
    Route::put('{lodge}', 'DetailController@update')->name('update');
});
Route::resource('organizations', 'OrganizationController');

Route::get('cities', 'CityController@index')->name('cities.index');
Route::get('metro', 'StationController@index')->name('stations.index');
