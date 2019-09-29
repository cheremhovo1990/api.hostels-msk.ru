<?php

/** @var $lodge \App\Models\Organization\Lodge|null */

?>
<form action="{{route('cp.lodge.images.store', ['lodge_id' => optional($lodge)->id])}}">
    <input type="file" id="js-input-lodge-images" class="form-control" accept="image/*" multiple>
</form>

<div id="image-container" data-url="{{route('cp.lodge.images', ['lodge_id' => optional($lodge)->id])}}">

</div>
