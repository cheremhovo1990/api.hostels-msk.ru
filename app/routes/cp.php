<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 27.10.18
 * Time: 17:53
 */

use Illuminate\Support\Facades\Route;

Route::resource('organizations', 'OrganizationController');

Route::get('organizations/details/{detail}/create', 'DetailController@create')->name('details.create');
Route::get('cities', 'CityController@index')->name('cities.index');
Route::get('metro', 'StationController@index')->name('stations.index');