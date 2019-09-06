<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 05.11.18
 * Time: 18:20
 */

/** @var $models \App\Models\City[]|\Illuminate\Support\Collection */

?>
@extends('cp')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
        </tr>
        </thead>
        <tbody>
        @foreach($models as $model)

            <tr>
                <th scope="row">{{$loop->index}}</th>
                <th scope="row">{{$model->id}}</th>
                <th scope="row">{{$model->name}}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
