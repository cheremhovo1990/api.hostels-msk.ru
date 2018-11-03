<?php

/** @var \App\Models\Organization\Organization $model */

$title = 'Edit ' . $model->name;

?>

@extends('cp')

@section('content')
    <div class="col-md-12">
        <h1>{{$title}}</h1>
        @include('cp/organization/error')
        <form action="{{route('cp.organizations.update', $model)}}" method="post">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="organization-name">Name</label>
                <input type="text" value="{{$model->name}}" class="form-control" name="name" id="organization-name"
                       aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="organization-status">Status</label>
                <select name="status" id="organization-status" class="form-control">
                    @foreach($nameDropDown as $key => $name)
                        <option value="{{$key}}">
                            {{$name}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Edit">
            </div>
        </form>
    </div>
@endsection