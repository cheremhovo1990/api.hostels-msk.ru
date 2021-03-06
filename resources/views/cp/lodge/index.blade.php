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

        <p>
            <a href="{{route('cp.lodges.create')}}" class="btn btn-primary">Create</a>
        </p>

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
                    <td class="d-flex">
                        <a href="{{route('cp.lodges.edit', [$model])}}" class="btn btn-primary">Update</a>
                        @if ($model->detail)
                            <a href="{{route('cp.details.edit', $model->detail)}}" class="btn btn-primary">2 gis</a>
                        @endif
                        <form action="{{route('cp.lodges.destroy', [$model])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary">delete</button>
                        </form>
                    </td>
                </tr>
                </tbody>

            @endforeach
        </table>
        {{$models->links()}}
    </div>

@endsection
