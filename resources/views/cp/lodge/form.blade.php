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
/** @var $organizationDropDown \Illuminate\Support\Collection */

$imageToken = optional($model)->image_token ?? uniqid('', true);

if (is_null($model)) {
    $route = route('cp.lodges.store');
} else {
    $route = route('cp.lodges.update', $model);
}

?>
@extends('cp')

@section('content')
    <div class="col-md-12">
        @include('cp/parts/error')
        <form action="{{$route}}" method="post">
            <?php if (!is_null($model)): ?>
            @method('PUT')
            <?php endif; ?>
            @csrf
            <div class="form-group required">
                <label for="lodge-organization">Organization</label>
                <select name="organization_id" id="lodge-organization" class="form-control">
                    <option value=""></option>
                    @foreach($organizationDropDown as $id => $organization)
                        <option value="{{$id}}" {{$id == optional($model)->organization_id ? 'selected': ''}}>{{$organization}}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group required">
                        <label for="lodge-announce">Announce</label>
                        <textarea name="announce" class="form-control ckeditor-editor"
                                  id="lodge-announce">{{old('announce', optional($model)->announce)}}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group required">
                        <label for="lodge-description">Description</label>
                        <textarea name="description" class="form-control ckeditor-editor"
                                  id="lodge-description">{{old('description', optional($model)->description)}}</textarea>
                    </div>
                </div>
            </div>

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
                    <input type="text" name="latitude" class="form-control" id="lodge-latitude" readonly
                           value="{{old('latitude', optional($model)->latitude)}}">
                </div>
                <div class="col form-group required">
                    <label for="lodge-longitude">Longitude</label>
                    <input type="text" name="longitude" class="form-control" id="lodge-longitude" readonly
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
            <input type="hidden" name="image_token" value="{{$imageToken}}">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" id="js-image-button-modal" data-toggle="modal"
                    data-target="#js-lodge-image-upload"
                    data-url-images="{{route('cp.api.lodge.images', ['token' => $imageToken])}}">
                Upload image
            </button>
            <div class="from-group mt-3">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
        <!-- Modal -->
        <div class="modal fade" id="js-lodge-image-upload" tabindex="-1" role="dialog"
             aria-labelledby="lodge-image-upload" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <form action="{{route('cp.api.lodge.images.store', ['token' => $imageToken])}}">
                            <input type="file" id="js-input-lodge-images" accept="image/*" multiple>
                        </form>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="js-lodge-preview-image">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="/build/js/jquery.inputmask.bundle.js" type="text/javascript"></script>
    <script src="/build/js/ckeditor/ckeditor.js"></script>
    @include('cp.parts.script-common')
    @include('cp.parts.lodge.script')
    @include('cp.lodge.script')
@endsection
