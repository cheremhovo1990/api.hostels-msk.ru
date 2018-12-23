<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 23.12.18
 * Time: 12:22
 */

/** @var $models \App\Models\Organization\Lodge[] */

$title = 'Lodges';

?>
@extends('cp')


@section('content')
    <div class="col-md-12">
        <h1>{{$title}}</h1>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID</th>
                <th scope="col">Organization</th>
                <th scope="col"></th>
            </tr>
            </thead>
            @foreach($models as $model)

                <tbody>
                <tr>
                    <th scope="row">{{ $loop->index }}</th>
                    <td>{{$model->id}}</td>
                    <td>{{$model->organization->name}}</td>
                    <td>
                        <a href="{{route('cp.details.edit', [$model->detail])}}" class="btn btn-primary">Update</a>
                    </td>
                </tr>
                </tbody>

            @endforeach
        </table>
        {{$models->links()}}
    </div>

@endsection