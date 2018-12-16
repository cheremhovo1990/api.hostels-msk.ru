<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 16.12.18
 * Time: 16:36
 */

/** @var $stations \App\Models\Metro[] */

?>
<div class="row">
    <div class="col-md-12">
        @foreach($stations as $station)
            <input type="hidden" name="stations[{{$loop->index}}][id]" value="{{$station->id}}">
            <input type="hidden" name="stations[{{$loop->index}}][distance]" value="{{$station->pivot->distance}}">
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
                    <td>{{$station->pivot->distance}}</td>
                    <td>{{$station->line_name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
