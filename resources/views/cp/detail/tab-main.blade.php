<div class="row">
    <div class="col-4">
        <div class="form-group required">
            <label for="lodge-organization">Organization</label>
            <select name="organization_id" id="lodge-organization" class="form-control" form="{{$formId}}">
                <option value=""></option>
                @foreach(\App\Helpers\OrganizationHelper::getDropDown() as $id => $name)
                    <option
                        value="{{$id}}" {{$id == old('organization_id', $organization->id) ? 'selected': ''}}>
                        {{$name}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group required">
            <label for="lodge-phone">Phone</label>
            <input type="tel" name="phone" class="form-control js-phone-mask" id="lodge-phone"
                   value="{{old('phone', optional($lodge)->phone)}}" form="{{$formId}}">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group required">
            <label for="lodge-status">Status</label>
            <select name="status" id="lodge-status" class="form-control" form="{{$formId}}">
                @foreach($statusDropDown as $id => $status)
                    <option value="{{$id}}" {{$id == optional($lodge)->status ? 'selected': ''}}>
                        {{$status}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
@if (!is_null($lodge))
    <p><a href="#" data-url="{{route('cp.api.lodge.generate-text', $lodge)}}"
          data-target=".editor-textarea" class="btn btn-success js-generate-text">Generate Text</a>
    </p>
@endif
<div class="form-group">
    <label for="lodge-announce">Announce</label>
    <textarea
        name="announce"
        class="form-control editor-textarea ckeditor-editor"
        id="lodge-announce"
        form="{{$formId}}"
    >{{old('announce', optional($lodge)->announce)}}</textarea>
</div>
<div class="form-group">
    <label for="lodge-description">Description</label>
    <textarea
        name="description"
        class="form-control ckeditor-editor"
        form="{{$formId}}"
        id="lodge-description"
    >{{old('description', optional($lodge)->description)}}</textarea>
</div>

<div class="row">
    <div class="col-6">
        <div class="form-group required">
            <label for="lodge-opening-hours">Opening Hours</label>
            <input type="text" name="opening_hours" id="lodge-opening-hours" class="form-control" form="{{$formId}}"
                   value="{{old('opening_hours', optional($lodge)->opening_hours)}}">
        </div>

    </div>
    <div class="col-6">
        <div class="form-group required">
            <label for="lodge-price_min">Price Min</label>
            <input type="number" name="price_min" class="form-control" id="lodge-price_min" form="{{$formId}}"
                   value="{{old('price_min', optional($property)->price_min)}}">
        </div>
    </div>
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
            @include('cp.parts.lodge.opening-hours-schema')
        @endforeach
    @endif
</div>
