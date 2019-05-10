<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 10.05.19
 * Time: 11:12
 */

/** @var $models \App\Models\Organization\Property[] */

$title = 'Property';

?>

@extends('cp')

@section('content')
    <div class="col-md-12">
        <h1>{{$title}}</h1>
        <p><a href="{{route('cp.properties.create')}}" class="btn btn-primary">Create</a></p>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Group</th>
                <th scope="col"></th>
            </tr>
            </thead>
            @foreach($models as $model)
                <tbody>
                <tr>
                    <th scope="row">{{ $loop->index }}</th>
                    <td>{{$model->id}}</td>
                    <td>{{$model->name}}</td>
                    <td>{{$model->group->name}}</td>
                    <td>
                        <a href="{{route('cp.properties.edit', [$model])}}" class="btn btn-primary">Update</a>
                    </td>
                </tr>
                </tbody>
            @endforeach
        </table>
    </div>
@endsection