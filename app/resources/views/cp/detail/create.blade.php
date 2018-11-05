<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 03.11.18
 * Time: 10:50
 */

/** @var $detail \App\Models\Pagination\Detail\Detail */
/** @var $statusDropDown array */
/** @var $cityDropDown \Illuminate\Support\Collection */

$title = $detail->name . " " . $detail->title;

?>
@extends('cp')

@section('content')
    <div class="col-md-12">
        <h1>{{$title}}</h1>
        <div class="row">
            <div class="col">
                @include('cp/parts/error')
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="lodge-announce">Announce</label>
                        <textarea name="announce" class="form-control" id="lodge-announce"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="lodge-description">Description</label>
                        <textarea name="description" class="form-control" id="lodge-description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="lodge-phone">Phone</label>
                        <input type="tel" name="phone" class="form-control js-phone-mask" id="lodge-phone">
                    </div>
                    <div class="form-group">
                        <label for="lodge-address">Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="city_id" class="form-control">
                                    @foreach($cityDropDown as $id => $city)
                                        <option value="{{$id}}">{{$city}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="text" name="address" class="form-control" id="lodge-address">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="lodge-status">Status</label>
                        <select name="status" id="lodge-status" class="form-control">
                            @foreach($statusDropDown as $id => $status)
                                <option value="{{$id}}">{{$status}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="lodge-latitude">Latitude</label>
                                <input type="number" name="latitude" class="form-control" id="lodge-latitude">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="lodge-longitude">Longitude</label>
                                <input type="number" name="longitude" class="form-control" id="lodge-longitude">
                            </div>
                        </div>
                    </div>
                    <div id="lodge-map">

                    </div>
                </form>
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
                @foreach($detail->images as $images)
                    <figure class="figure">
                        <img src="{{$images->src}}" alt="" style="max-width: 200px">
                    </figure>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="/js/jquery.inputmask.bundle.js" type="text/javascript"></script>
    <script>
        Map = function () {
            this.mapDetail = null;
            this.mapLodge = null;
            this.lodge();
            this.detail();
        };
        Map.prototype.detail = function () {
            let id = 'detail-map';
            let coordinates = $('#' + id).data('coordinates');
            this.mapDetail = new ymaps.Map(id, {
                'center': coordinates,
                'zoom': 15,
                'controls': [],
            });
            let placemark = new ymaps.Placemark(coordinates);
            this.mapDetail.geoObjects.add(placemark);
        };
        Map.prototype.lodge = function () {
            self = this;
            $('.js-coordinates-copy').on('click', function () {
                let coordinates = $('#detail-map').data('coordinates');
                $('#lodge-latitude').val(coordinates[0]);
                $('#lodge-longitude').val(coordinates[1]);
                self.createMap('lodge-map', coordinates);
            });
        };
        Map.prototype.createMap = function (id, coordinates) {
            if (this.mapLodge != null) {
                this.mapLodge.destroy();
            }
            $('#' + id).css({'height': '200px'});
            this.mapLodge = new ymaps.Map(id, {
                'center': coordinates,
                'zoom': 15,
                'controls': [],
            });
            let placemark = new ymaps.Placemark(coordinates);
            this.mapLodge.geoObjects.add(placemark);
        };
        ymaps.ready(function () {
            let map = new Map();
        });
        $('.js-phone-mask').inputmask("+7(999)999-99-99");
    </script>
@endsection