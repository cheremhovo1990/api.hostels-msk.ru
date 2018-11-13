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