<?php

/** @var $lodge \App\Models\Organization\Lodge */
if (isset($lodge)) {
    $property = $lodge->property;
} else {
    $property = null;
}
?>

<div class="row">

    @foreach(\App\Helpers\PropertyHelper::getDropDown() as $item)
        <div class="col-6">
            <div class="form-check">
                <input type="hidden" name="properties[{{$item['name']}}]" value="0" form="{{$formId}}">
                <input class="form-check-input" name="properties[{{$item['name']}}]" type="checkbox" value="1"
                       {{(bool)(int)old("properties.${item['name']}", optional($property)->{$item['name']}) ? ' checked': ''}}
                       id="properties-{{$item['name']}}" form="{{$formId}}">
                <label class="form-check-label" for="properties-{{$item['name']}}">
                    {{$item['label']}}
                </label>
            </div>
        </div>
    @endforeach

</div>
