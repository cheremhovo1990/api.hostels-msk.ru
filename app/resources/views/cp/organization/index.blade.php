<?php

/** @var $organizations \App\Models\Organization\Organization[]|\Illuminate\Pagination\LengthAwarePaginator */
$title = 'Organizations';

?>
@extends('cp')

@section('content')
    <div class="col-md-12">
        <h1>{{$title}}</h1>
        <p>
            <a href="{{route('cp.organizations.create')}}" class="btn btn-primary">Create</a>
        </p>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">
                    @if (request('id') != 'asc')
                        <a href="{{request()->fullUrlWithQuery(['id' => 'asc'])}}">ID desc</a>
                    @else
                        <a href="{{request()->fullUrlWithQuery(['id' => 'desc'])}}">ID asc</a>
                    @endif
                </th>
                <th scope="col">Name</th>
                <th scope="col"></th>
            </tr>
            </thead>
            @foreach($organizations as $organization)

                <tbody>
                <tr>
                    <th scope="row">{{ $loop->index }}</th>
                    <td>{{$organization->id}}</td>
                    <td>{{$organization->name}}</td>
                    <td>
                        <form action="{{route('cp.organizations.destroy', $organization)}}" method="post">
                            @method('DELETE')
                            @csrf
                            <input type="submit" value="Delete" class="btn btn-primary">

                            <a href="{{route('cp.organizations.show', $organization)}}" class="btn-primary btn">Show</a>
                            <a href="{{route('cp.organizations.edit', $organization)}}"
                               class="btn-primary btn">Update</a>
                        </form>
                    </td>
                </tr>
                </tbody>

            @endforeach
        </table>
        {{$organizations->links()}}
    </div>

@endsection