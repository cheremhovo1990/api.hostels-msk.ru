<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 24.11.18
 * Time: 16:03
 */

use App\Models\Image;

/** @var $images \App\Models\Image[] */

?>

<div class="row">
    <?php foreach ($images as $image): ?>
    <div class="col-md-3">
        <img src="" alt="">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <a href="{{route('cp.lodge.image.destroy', [$image])}}" class="js-image-destroy">delete</a>
            </div>
            <div>
                <label class="mb-0">
                    <input type="radio" name="main" value="{{$image->id}}"
                           {{$image->isMain()? 'checked':''}} class="js-image-main"
                           data-url="{{route('cp.lodge.image.main')}}">
                    Main
                </label>
            </div>
        </div>

    </div>
    <?php endforeach; ?>
</div>
