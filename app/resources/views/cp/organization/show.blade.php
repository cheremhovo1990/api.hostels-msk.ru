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
        @if($details->isNotEmpty())
            <div class="row">
                <div class="col-md-12">
                    <h2>2gis</h2>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        @foreach($details as $detail)
                            <tbody>
                            <tr>
                                <th scope="row">{{ $loop->index }}</th>
                                <td>{{$detail->id}}</td>
                                <td>{{$detail->title}}</td>
                                @if (is_null($detail->lodge_id))
                                    <td>
                                        <a href="{{route('cp.details.create', [$detail])}}">Create</a>
                                    </td>
                                @else
                                    <td>
                                        <a href="{{route('cp.details.edit', [$detail])}}">Update</a>
                                        <form action="{{route('cp.details.destroy', [$detail])}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button>Delete</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                            </tbody>
                        @endforeach
                    </table>
                    {{$details->links()}}
                </div>
            </div>
        @else
            <div class="row">
                <p>not in 2gis</p>
            </div>
        @endif
    </div>
@endsection