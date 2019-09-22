<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 17.11.18
 * Time: 13:34
 */

/** @var $model \App\Models\Municipality */

?>

<div class="row">
    <div class="col-md-12">
        @if(!is_null($model))
            <input type="hidden" name="municipality_id" value="{{$model->id}}">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Administrative district</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$model->id}}</td>
                    <td>{{$model->name}}</td>
                    <td>{{$model->district->name}}</td>
                </tr>
                </tbody>
            </table>
        @else
            <input type="hidden" name="municipality_id" value="">
            <p>not result</p>
        @endif

    </div>
</div>
