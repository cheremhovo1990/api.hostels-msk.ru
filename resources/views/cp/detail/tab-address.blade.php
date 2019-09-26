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
