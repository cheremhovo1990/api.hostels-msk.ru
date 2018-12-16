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
$imageToken = optional($lodge)->image_token ?? uniqid('', true);

?>
@extends('cp')

@section('style')
    @parent
    div.required label:after {
    content: " *";
    color: red;
    }
@endsection

@section('content')
    <div class="col-md-12">
        <h1>{{$title}}</h1>
        <div class="row">
            <div class="col">
                @include('cp/parts/error')
                <form action="{{route('cp.details.store', [$detail])}}" method="post">
                    @csrf
                    <div class="form-group required">
                        <label for="lodge-announce">Announce</label>
                        <textarea name="announce" class="form-control ckeditor-editor"
                                  id="lodge-announce">{{old('announce', optional($lodge)->announce)}}</textarea>
                    </div>
                    <div class="form-group required">
                        <label for="lodge-description">Description</label>
                        <textarea name="description" class="form-control ckeditor-editor"
                                  id="lodge-description">{{old('description', optional($lodge)->description)}}</textarea>
                    </div>
                    <div class="form-group required">
                        <label for="lodge-phone">Phone</label>
                        <input type="tel" name="phone" class="form-control js-phone-mask" id="lodge-phone"
                               value="{{old('phone', optional($lodge)->phone)}}">
                    </div>
                    <div class="form-group required">
                        <label for="lodge-address">Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="city_id" class="form-control">
                                    @foreach($cityDropDown as $id => $city)
                                        <option value="{{$id}}" {{$id == optional($lodge)->city_id ? 'selected': ''}}>{{$city}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="text" name="address" class="form-control" id="lodge-address"
                                   value="{{old('address', optional($lodge)->address)}}">
                        </div>

                    </div>
                    <div class="form-group required">
                        <label for="lodge-status">Status</label>
                        <select name="status" id="lodge-status" class="form-control">
                            @foreach($statusDropDown as $id => $status)
                                <option value="{{$id}}" {{$id == optional($lodge)->status ? 'selected': ''}}>{{$status}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group required">
                        <label for="lodge-opening-hours">Opening Hours</label>
                        <input type="text" name="opening_hours" id="lodge-opening-hours" class="form-control"
                               value="{{old('opening_hours', optional($lodge)->opening_hours)}}">
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
                        @if (!is_null($lodge))
                            @foreach($lodge->schema_org['opening_hours'] as $opening_hour)
                                @include('cp.detail.opening-hours-schema')
                            @endforeach
                        @endif
                    </div>
                    <div class="row">
                        <div class="col form-group required">
                            <label for="lodge-latitude">Latitude</label>
                            <input type="text" name="latitude" class="form-control" id="lodge-latitude"
                                   value="{{old('latitude', optional($lodge)->latitude)}}">
                        </div>
                        <div class="col form-group required">
                            <label for="lodge-longitude">Longitude</label>
                            <input type="text" name="longitude" class="form-control" id="lodge-longitude"
                                   value="{{old('longitude', optional($lodge)->longitude)}}">
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
                        @if (!is_null($lodge))
                            @include('cp/detail/distance', ['stations' => $lodge->stations])
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button id="js-button-district" class="btn btn-primary btn-lg btn-block">
                                Administrative District
                            </button>
                        </div>
                    </div>
                    <div id="js-district-view">
                        @if (!is_null($lodge))
                            @include('cp/api/district/view', ['model' => $lodge->district])
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
                        @if (!is_null($lodge))
                            @include('cp/api/municipality/view', ['model' => $lodge->municipality])
                        @endif
                    </div>
                    <div id="lodge-map" class="mt-3">

                    </div>
                    <input type="hidden" name="image_token" value="{{$imageToken}}">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" id="js-image-button-modal" data-toggle="modal"
                            data-target="#lodge-image-upload"
                            data-url-images="{{route('cp.api.lodge.images', ['token' => $imageToken])}}">
                        Upload image
                    </button>
                    <div class="form-group mt-3">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
                <!-- Modal -->
                <div class="modal fade" id="lodge-image-upload" tabindex="-1" role="dialog"
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
                            <div class="modal-body" id="lodge-preview-image">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <h3>Name</h3>
                        <p>
                            {{$detail->name}}
                        </p>
                    </div>
                    <div class="col">
                        <h3>Title</h3>
                        <p>
                            {{$detail->title}}
                        </p>

                    </div>
                </div>
                <h3>Text</h3>
                <p>
                    {{$detail->text}}
                </p>
                <h3>Description</h3>
                @foreach($detail->descriptions as $description)
                    <p>{{$description->description}}</p>
                @endforeach
                <h3>Phones</h3>
                @foreach($detail->phones as $phone)
                    <p>{{$phone->phone}}</p>
                @endforeach
                <h3>Address</h3>
                <p>
                    {{$detail->address}}
                </p>
                <h2>latitude and Longitude</h2>
                <p>
                    {{$detail->latitude}} {{$detail->longitude}}
                    <button class="js-coordinates-copy btn btn-primary">Copy</button>
                </p>
                <div id="detail-map" style="height: 200px"
                     data-coordinates="{{collect([$detail->latitude, $detail->longitude])}}">

                </div>
                <h3>work_hour</h3>
                <p>
                    {{$detail->work_hour}}
                </p>
                <div class="row">
                    <div class="col">
                        <h3>Site</h3>
                        <p>
                            {{$detail->site}}
                        </p>
                    </div>
                    <div class="col">
                        <h3>Email</h3>
                        <p>
                            {{$detail->email}}
                        </p>
                    </div>
                </div>
                <h3>Attributes</h3>
                @foreach($detail->detailAttributes as $attribute)
                    <p>{{$attribute->attribute}}</p>
                @endforeach
                <h3>Images</h3>
                <p>
                    <a href="#" class="btn btn-primary" id="js-image-add-all">Add all</a>
                </p>
                <div class="row" id="js-image-url"
                     data-url="{{route('cp.api.lodge.image.store', ['token' => $imageToken])}}">
                    @foreach($detail->images as $image)
                        <div class="col">
                            <div class="row">
                                <figure class="figure">
                                    <img src="{{$image->src}}" id="js-image-add-{{$image->id}}" alt=""
                                         style="max-width: 200px">
                                </figure>
                            </div>

                            <a href="#" data-target="#js-image-add-{{$image->id}}" class="js-add-image">add</a>
                        </div>

                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="/js/jquery.inputmask.bundle.js" type="text/javascript"></script>
    <script src="/js/ckeditor/ckeditor.js"></script>
    @include('cp.detail.script')
@endsection