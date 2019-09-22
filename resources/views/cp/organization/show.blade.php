<?php

/** @var $details \App\Models\Pagination\Detail\Detail[]|\Illuminate\Support\Collection */
/** @var $model \App\Models\Organization\Organization */


$title = $model->name;

?>

@extends('cp')

@section('content')

    <div class="col-md-12">
        <h1>{{$title}}</h1>
        <div class="row">
            <div class="col-md-1">
                Name
            </div>
            <div class="col-md-11">
                {{$model->name}}
            </div>
            <div class="col-md-1">
                Status
            </div>
            <div class="col-md-11">
                {{$model->getStatus()}}
            </div>
        </div>
    </div>
@endsection
