<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 24.03.19
 * Time: 15:36
 */

/** @var $model \App\Models\Organization\Lodge */
/** @var $cityDropDown \Illuminate\Support\Collection */
/** @var $statusDropDown \Illuminate\Support\Collection */

?>
@extends('cp')

@section('content')
    <div class="col-md-12">
        <form action="{{route('cp.lodges.update', $model)}}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group required">
                <label for="lodge-announce">Announce</label>
                <textarea name="announce" class="form-control ckeditor-editor"
                          id="lodge-announce">{{old('announce', optional($model)->announce)}}</textarea>
            </div>
            <?php if (!is_null($model->id)): ?>
            <a href="{{route('cp.api.text.generate', ['lodge' => $model])}}" id="js-announce-generate"
               class="btn btn-primary mt-1">Generate</a>
            <?php endif; ?>
            <div class="form-group required mt-2">
                <label for="lodge-description">Description</label>
                <textarea name="description" class="form-control ckeditor-editor"
                          id="lodge-description">{{old('description', optional($model)->description)}}</textarea>
            </div>
            <?php if (!is_null($model->id)): ?>
            <a href="{{route('cp.api.text.generate', ['lodge' => $model])}}" id="js-description-generate"
               class="btn btn-primary mt-1">Generate</a>
            <?php endif; ?>
            <div class="form-group required">
                <label for="lodge-phone">Phone</label>
                <input type="tel" name="phone" class="form-control js-phone-mask" id="lodge-phone"
                       value="{{old('phone', optional($model)->phone)}}">
            </div>

            <div class="form-group required">
                <label for="lodge-status">Status</label>
                <select name="status" id="lodge-status" class="form-control">
                    @foreach($statusDropDown as $id => $status)
                        <option value="{{$id}}" {{$id == optional($model)->status ? 'selected': ''}}>{{$status}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group required">
                <label for="lodge-opening-hours">Opening Hours</label>
                <input type="text" name="opening_hours" id="lodge-opening-hours" class="form-control"
                       value="{{old('opening_hours', optional($model)->opening_hours)}}">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" id="add-input-opening-hours-schema"
                        data-html='@include('cp.detail.opening-hours-schema')'>Add Schema.org
                </button>
                <small id="emailHelp" class="form-text text-muted"><a href="https://schema.org/openingHours"
                                                                      target="_blank">https://schema.org/openingHours</a>
                </small>
            </div>
            <div id="container-for-opening-hours-schema">
                @if (!is_null($model))
                    @foreach($model->schema_org['opening_hours'] as $opening_hour)
                        @include('cp.parts.lodge.opening-hours-schema')
                    @endforeach
                @endif
            </div>
            <div class="row">
                <div class="col form-group required">
                    <label for="lodge-latitude">Latitude</label>
                    <input type="text" name="latitude" class="form-control" id="lodge-latitude" disabled
                           value="{{old('latitude', optional($model)->latitude)}}">
                </div>
                <div class="col form-group required">
                    <label for="lodge-longitude">Longitude</label>
                    <input type="text" name="longitude" class="form-control" id="lodge-longitude" disabled
                           value="{{old('longitude', optional($model)->longitude)}}">
                </div>
                <div class="col form-group">
                    <label for="lodge-distance">Distance</label>
                    <div class="input-group">
                        <input type="number" value="1000" class="form-control" id="lodge-distance">
                        <div class="input-group-append">
                            <button class="form-control btn-primary btn" id="js-lodge-station-distance">
                                Distance
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="js-show-station-distance">
                @if (!is_null($model))
                    @include('cp/detail/distance', ['stations' => $model->stations])
                @endif
            </div>
            <div class="form-group required">
                <label for="lodge-address">Address</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <select name="city_id" class="form-control" id="lodge-city">
                            @foreach($cityDropDown as $id => $city)
                                <option value="{{$id}}" {{$id == optional($model)->city_id ? 'selected': ''}}>{{$city}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" name="address" class="form-control" id="lodge-address"
                           value="{{old('address', optional($model)->address)}}">
                    <div class="input-group-prepend">
                        <button class="btn btn-primary" id="js-search-map">Search Map</button>
                    </div>
                </div>
                <div id="js-lodge-address-error" class="form-text text-danger"></div>
            </div>
            <div id="map" style="height: 400px; width: 100%"></div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <button id="js-button-district" class="btn btn-primary btn-lg btn-block">
                        Administrative District
                    </button>
                </div>
            </div>
            <div id="js-district-view">
                @if (!is_null($model))
                    @include('cp/api/district/view', ['model' => $model->district])
                @endif
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <button id="js-button-municipality" class="btn btn-primary btn-lg btn-block">
                        Municipality
                    </button>
                </div>
            </div>
            <div id="js-municipality-view">
                @if (!is_null($model))
                    @include('cp/api/municipality/view', ['model' => $model->municipality])
                @endif
            </div>
            <div class="from-group mt-3">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    @parent
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="/js/jquery.inputmask.bundle.js" type="text/javascript"></script>
    <script src="/js/ckeditor/ckeditor.js"></script>
    @include('cp.parts.script-common')
    @include('cp.parts.lodge.script')
    @include('cp.lodge.script')
@endsection