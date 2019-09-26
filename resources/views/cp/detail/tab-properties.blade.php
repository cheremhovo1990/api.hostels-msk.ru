<div class="row">

    @foreach(\App\Helpers\PropertyHelper::getDropDown() as $property)
        <div class="col-6">
            <div class="form-check">
                <input type="hidden" name="properties[{{$property['name']}}]" value="0">
                <input class="form-check-input" name="properties[{{$property['name']}}]" type="checkbox" value="1"
                       id="properties-{{$property['name']}}">
                <label class="form-check-label" for="properties-{{$property['name']}}">
                    {{$property['label']}}
                </label>
            </div>
        </div>
    @endforeach

</div>
