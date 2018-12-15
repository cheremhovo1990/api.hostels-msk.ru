<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 13.11.18
 * Time: 7:34
 */

use App\Models\Metro;
use App\Services\MetroDistanceService;

/** @var $stations Metro */
/** @var $latitude float */
/** @var $longitude float */

$distance = app(MetroDistanceService::class);

?>

<div class="row">
    <div class="col-md-12">
        @foreach($stations as $station)
            <input type="hidden" name="stations[{{$loop->index}}][id]" value="{{$station->id}}">
            <input type="hidden" name="stations[{{$loop->index}}][distance]"
                   value="{{$distance->distance($latitude, $longitude, $station)}}">
        @endforeach
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Distance</th>
                <th scope="col">Line</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stations as $station)
                <tr>
                    <th scope="row">{{$loop->index}}</th>
                    <td>{{$station->id}}</td>
                    <td>{{$station->name}}</td>
                    <td>{{$distance->distance($latitude, $longitude, $station)}}</td>
                    <td>{{$station->line_name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>


