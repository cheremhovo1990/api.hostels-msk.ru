<?php

/** @var $models [] \App\Models\Pagination\Detail\Detail */

?>

@extends('cp')

@section('content')

    <div class="col-12">
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
                let placemark = new ymaps.Placemark(
                    [details[i].latitude, details[i].longitude],
                    {
                        balloonContent: 'test',
                    }
                );
                clusterer.add(placemark);
            }
        }
    </script>
@endsection
