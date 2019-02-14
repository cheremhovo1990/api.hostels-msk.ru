<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 05.11.18
 * Time: 18:33
 */

/** @var $models \App\Models\MetroStation[]|\Illuminate\Support\Collection */

?>
@extends('cp')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Order</th>
            <th scope="col">Color</th>
            <th scope="col">Line name</th>
        </tr>
        </thead>
        <tbody>
        @foreach($models as $model)
            <tr>
                <th scope="row">{{$loop->index}}</th>
                <td>{{$model->id}}</td>
                <td>{{$model->name}}</td>
                <td>{{$model->order}}</td>
                <td>{{$model->hex_color}}</td>
                <td>{{$model->line_name}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection