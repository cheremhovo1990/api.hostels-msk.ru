<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 24.03.19
 * Time: 15:36
 */

/** @var $model \App\Models\Organization\Lodge */
/** @var $cityDropDown \Illuminate\Support\Collection */

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
            <div class="form-group required">
                <label for="lodge-description">Description</label>
                <textarea name="description" class="form-control ckeditor-editor"
                          id="lodge-description">{{old('description', optional($model)->description)}}</textarea>
            </div>
            <div class="form-group required">
                <label for="lodge-phone">Phone</label>
                <input type="tel" name="phone" class="form-control js-phone-mask" id="lodge-phone"
                       value="{{old('phone', optional($model)->phone)}}">
            </div>
            <div class="form-group required">
                <label for="lodge-address">Address</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <select name="city_id" class="form-control">
                            @foreach($cityDropDown as $id => $city)
                                <option value="{{$id}}" {{$id == optional($model)->city_id ? 'selected': ''}}>{{$city}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" name="address" class="form-control" id="lodge-address"
                           value="{{old('address', optional($model)->address)}}">
                </div>
            </div>
            <div class="from-group">
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
@endsection