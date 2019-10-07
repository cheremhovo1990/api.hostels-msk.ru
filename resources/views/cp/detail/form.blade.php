<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 03.11.18
 * Time: 10:50
 */

/** @var $detail \App\Models\Pagination\Detail\Detail */
/** @var $lodge \App\Models\Organization\Lodge */
/** @var $statusDropDown array */
/** @var $cityDropDown \Illuminate\Support\Collection */

$title = $detail->name . " " . $detail->title;

$url = is_null($lodge) ? route('cp.details.store', [$detail]) : route('cp.details.update', [$lodge]);

$formId = 'form-lodge';

if (isset($lodge)) {
    $property = $lodge->property;
} else {
    $property = null;
}

?>
@extends('cp')

@section('content')
    <div class="col-md-12">
        <h1>{{$title}}</h1>
        <div class="row">
            <div class="col">
                @include('cp/parts/error')

                <div class="row">
                    <div class="col-12">

                    </div>
                </div>
                <form action="{{$url}}" method="post" id="{{$formId}}">
                    @csrf
                    @if (!is_null($lodge))
                        @method('PUT')
                    @endif
                </form>
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="list" href="#tab-main">Main</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="list" href="#tab-address">Address</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="list" href="#tab-properties">Properties</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="list" href="#tab-image">Image</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-main">
                        @include('cp.detail.tab-main')
                    </div>
                    <div class="tab-pane fade" id="tab-address">
                        @include('cp.detail.tab-address')
                    </div>
                    <div class="tab-pane fade" id="tab-properties">
                        @include('cp.detail.tab-properties')
                    </div>
                    <div class="tab-pane fade" id="tab-image">
                        @include('cp.detail.tab-image')
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button class="btn btn-primary" form="{{$formId}}">Save</button>
                </div>
            </div>
            @include('cp.detail.form-right')
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="/build/js/jquery.inputmask.bundle.js" type="text/javascript"></script>
    <script src="/build/js/ckeditor/ckeditor.js"></script>
    @include('cp.parts.script-common')
    @include('cp.detail.script')
    @include('cp.parts.lodge.script')
@endsection
