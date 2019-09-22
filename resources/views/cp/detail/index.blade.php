<?php

/** @var $models [] \App\Models\Pagination\Detail\Detail */
/** @var $models [] \App\Models\Pagination\Detail\Detail */
/** @var $station \App\Models\MetroStation */

?>

@extends('cp')

@section('content')
    <div class="col-4">
        <form action="" id="form-detail-search">
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
                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modal-search-by-metro">
                    @if (is_null($station))
                        Station Metro
                    @else
                        м. <?= $station->name ?>
                    @endif

                </a>

                <div class="modal fade" id="modal-search-by-metro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="list-group" id="list-tab" role="tablist">
                                            @foreach ($groupStation as $name => $stations)
                                                <a class="list-group-item list-group-item-action {{$loop->first? ' active': ''}}" id="list-home-list" data-toggle="list" href="#{{ \Illuminate\Support\Str::slug($name)}}" role="tab" aria-controls="home">{{$name}}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="tab-content" id="nav-tabContent">
                                            @foreach ($groupStation as $name => $stations)
                                                <div class="tab-pane fade {{$loop->first? ' show active': ''}}" id="{{ \Illuminate\Support\Str::slug($name)}}" role="tabpanel" aria-labelledby="list-home-list">
                                                    <ul>
                                                        @foreach($stations as $station)
                                                            <li><a href="{{request()->fullUrlWithQuery(['station' => $station->id])}}">{{$station->name}}</a></li>
                                                        @endforeach
                                                    </ul>

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
        $('#form-detail-search select').change(function () {
            this.form.submit();
        });

    </script>
@endsection
