<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 10.05.19
 * Time: 12:10
 */

/** @var $model \App\Models\Organization\Property */
/** @var $groupDropDown array */

if (is_null($model)) {
    $action = route('cp.properties.store');
} else {
    $action = route('cp.properties.update', [$model]);
}

?>

@extends('cp')

@section('content')
    <div class="col-md-12">
        <form action="{{$action}}" class="form" method="post">
            @csrf
            <?php if (!is_null($model)): ?>
            @method('PUT')
            <?php endif; ?>
            <div class="form-group required">
                <label for="property-group">Group</label>
                <select name="group_id" id="property-group" class="form-control">
                    @foreach($groupDropDown as $id => $group)
                        <option value="{{$id}}" {{$id == old('group_id', optional($model)->group_id)? 'selected': ''}} >{{$group}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group required">
                <label for="property-name">Name</label>
                <input type="text" name="name" value="{{old('name', optional($model)->name)}}" class="form-control"
                       id="property-name">
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection
