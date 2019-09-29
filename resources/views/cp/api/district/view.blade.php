<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 17.11.18
 * Time: 13:34
 */

/** @var $model \App\Models\District */

?>

<div class="row">
    <div class="col-md-12">
        @if (!is_null($model))
            <input type="hidden" name="administrative_district_id" value="{{$model->id}}" form="{{$formId}}">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Abbrev</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$model->id}}</td>
                    <td>{{$model->name}}</td>
                    <td>{{$model->abbrev}}</td>
                </tr>
                </tbody>
            </table>
        @else
            <input type="hidden" name="administrative_district_id" value="" form="{{$formId}}">
            <p>Not results</p>
        @endif

    </div>
</div>
