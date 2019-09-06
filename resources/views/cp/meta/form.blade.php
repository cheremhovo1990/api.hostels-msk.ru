<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 09.05.19
 * Time: 12:13
 */

/** @var $model \App\Models\Meta|null */
/** @var $pageIdentityDropDown array */

if (is_null($model)) {
    $route = route('cp.meta.store');
} else {
    $route = route('cp.meta.update', [$model]);
}

?>
@extends('cp')

@section('content')
    <div class="col-md-12">
        @include('cp/parts/error')
        <form action="{{$route}}" method="post">
            @csrf
            <?php if (!is_null($model)): ?>
            @method('PUT')
            <?php endif; ?>
            <div class="form-group required">
                <label for="meta-page-identify">Page identify</label>
                <select name="page_identify" id="meta-page-identify" class="form-control">
                    @foreach($pageIdentityDropDown as $pageIdentity)
                        <option value="{{$pageIdentity}}" {{($pageIdentity == optional($model)->page_identify)?'selected': ''}}>{{$pageIdentity}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group required">
                <label for="meta-description">Description</label>
                <textarea name="description" id="meta-description"
                          class="form-control">{{old('description', optional($model)->description)}}</textarea>
            </div>
            <div class="form-group required">
                <label for="meta-title">title</label>
                <input type="text" name="title" value="{{old('title', optional($model)->title)}}" id="meta-title"
                       class="form-control">
            </div>
            <div class="form-group  required">
                <label for="meta-h1">h1</label>
                <input type="text" name="h1" value="{{old('h1', optional($model)->h1)}}" id="meta-h1"
                       class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

@endsection
