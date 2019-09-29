<?php

?>
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
        <p>
            {{$phone->phone}}
            <a href="" class="js-copy" data-content="{{$phone->phone}}" data-target="#lodge-phone"><span
                    class="fa fa-copy" title="copy"></span></a>
        </p>
    @endforeach
    <h3>Address</h3>
    <p>
        {{$detail->address}}
        <a href="" class="js-copy" data-content="{{$detail->address}}" data-target="#lodge-address"><span
                class="fa fa-copy" title="copy"></span></a>
    </p>
    <h2>latitude and Longitude</h2>
    <p>
        {{$detail->latitude}} {{$detail->longitude}}
        <a href="#" class="js-coordinates-copy"><span class="fa fa-copy" title="copy"></span></a>
    </p>
    <div id="detail-map" style="height: 200px"
         data-coordinates="{{collect([$detail->latitude, $detail->longitude])}}">

    </div>
    <h3>work_hour</h3>
    <p>
        {{$detail->work_hour}}
        <a href="" class="js-copy" data-content="{{$detail->work_hour}}" data-target="#lodge-opening-hours"><span
                class="fa fa-copy" title="copy"></span></a>
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
    <div class="row" id="js-image-container"
         data-url="{{route('cp.lodge.image.store', ['lodge_id' => optional($lodge)->id])}}">
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
