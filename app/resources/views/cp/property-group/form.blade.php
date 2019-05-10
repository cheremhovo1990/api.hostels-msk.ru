<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 10.05.19
 * Time: 9:39
 */

/** @var $model \App\Models\Organization\PropertyGroup */

if (is_null($model)) {
    $action = route('cp.property-groups.store');
} else {
    $action = route('cp.property-groups.update', [$model]);
}

?>

@extends('cp')


@section('content')
    <div class="col-md-12">
        <form action="{{$action}}" method="post" class="form">
            @csrf
            <?php if (!is_null($model)): ?>
            @method('PUT')
            <?php endif; ?>
            <div class="form-group required">
                <label for="property-group-name">Name</label>
                <input type="text" name="name" id="property-group-name" value="{{old('name', optional($model)->name)}}"
                       class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>

    </div>
@endsection