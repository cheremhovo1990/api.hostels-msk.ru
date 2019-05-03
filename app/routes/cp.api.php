<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 10.11.18
 * Time: 11:42
 */

Route::get('station-by-coordinates/lat/{latitude}/lon/{longitude}/dist/{distance}', function (\App\Services\MetroDistanceService $metroDistanceService, float $latitude, float $longitude, int $distance) {
    $stations = $metroDistanceService->getMetro($latitude, $longitude, $distance)->all();

    return view('cp/api/station/distance', [
        'stations' => $stations,
        'latitude' => $latitude,
        'longitude' => $longitude
    ]);
})->name('station.distance');

Route::get('administrative-district/lat/{latitude}/lon/{longitude}', function ($latitude, $longitude) {
    $model = \App\Models\District::byLatitudeLongitude((float)$latitude, (float)$longitude)->first();
    if (is_null($model)) {
        return '<p>Not results</p>';
    }
    return view('cp/api/district/view', ['model' => $model]);
})->name('administrative-district.view');

Route::get('municipality/lat/{latitude}/lon/{longitude}', function ($latitude, $longitude) {
    $model = \App\Models\Municipality::byLatitudeLongitude((float)$latitude, (float)$longitude)->first();
    if (is_null($model)) {
        return '<p>Not results</p>';
    }
    return view('cp/api/municipality/view', ['model' => $model]);
})->name('municipality.view');

Route::get('lodge/images/{token}', 'LodgeController@viewImages')->name('lodge.images');
Route::post('lodge/images/{token}', 'LodgeController@storeImages')->name('lodge.images.store');
Route::post('lodge/image/{token}', 'LodgeController@storeImage')->name('lodge.image.store');
Route::delete('lodge/image/{image}', 'LodgeController@destroyImage')->name('lodge.image.destroy');

Route::get('text/generate/{lodge}', 'TextController@generate')->name('text.generate');