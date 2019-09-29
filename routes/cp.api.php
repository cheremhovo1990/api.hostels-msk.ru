<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 10.11.18
 * Time: 11:42
 */

use Illuminate\Support\Facades\Route;

Route::get('station-by-coordinates/lat/{latitude}/lon/{longitude}/dist/{distance}', function (\App\Services\MetroDistanceService $metroDistanceService, float $latitude, float $longitude, int $distance) {
    $stations = $metroDistanceService->getMetro($latitude, $longitude, $distance)->all();

    return view('cp/api/station/distance', [
        'stations' => $stations,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'formId' => 'form-lodge',
    ]);
})->name('station.distance');

Route::get('administrative-district/lat/{latitude}/lon/{longitude}', function ($latitude, $longitude) {
    $model = \App\Models\District::byLatitudeLongitude((float)$latitude, (float)$longitude)->first();
    return view(
        'cp/api/district/view', [
        'model' => $model,
        'formId' => 'form-lodge',
    ]);
})->name('administrative-district.view');

Route::get('municipality/lat/{latitude}/lon/{longitude}', function ($latitude, $longitude) {
    $model = \App\Models\Municipality::byLatitudeLongitude((float)$latitude, (float)$longitude)->first();
    return view('cp/api/municipality/view', [
        'model' => $model,
        'formId' => 'form-lodge',
    ]);
})->name('municipality.view');


Route::group(['prefix' => 'lodge', 'as' => 'lodge.'], function () {
    Route::get('generate-text/{lodge}', 'LodgeController@generateText')->name('generate-text');
});

