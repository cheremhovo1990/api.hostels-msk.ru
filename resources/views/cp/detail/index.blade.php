<?php

/** @var $models [] \App\Models\Pagination\Detail\Detail */

?>

@extends('cp')

@section('content')
    <div class="col-4">
        <form action="">
            <div class="form-group">
                <label for="organization" class="col-form-label">Organization</label>
                <select name="organization" id="organization" class="form-control select2">
                    <option value=""></option>
                    @foreach(\App\Helpers\OrganizationHelper::getDropDown() as $id => $name)
                        <option value="{{$id}}" {{request('organization') == $id ? ' selected': ''}}>{{$name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Search</button>
            </div>
        </form>
    </div>
    <div class="col-8">
        <div id="map" class="w-100" style="height: calc(100vh - 3.5em)"
             data-details='@json((new \App\Http\Resources\Parse\DetailCollection($models))->toArray(null))'></div>
    </div>
@endsection

@section('script')
    @parent()
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script>
        ymaps.ready(init);

        function init() {
            // Создание карты.
            let myMap = new ymaps.Map("map", {
                center: [55.76, 37.64],
                zoom: 11
            });
            let clusterer = new ymaps.Clusterer({
                preset: 'islands#invertedBlueClusterIcons',
            });
            myMap.geoObjects.add(clusterer);
            let details = $('#map').data('details');
            for (let i = 0; i < details.length; i++) {
                let detail = details[i];
                let placemark = new ymaps.Placemark(
                    [detail.latitude, detail.longitude],
                    {
                        balloonContent: '<a href="' + detail.url + '">Организация:' + detail.name + '<br></a>',
                    }
                );
                clusterer.add(placemark);
            }
        }
    </script>
@endsection
