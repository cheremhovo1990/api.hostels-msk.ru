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
        <img src="/{{Image::ROOT_FOLDER}}/<?= $image->getUrl(160) ?>" alt="">
        <a href="{{route('cp.api.lodge.image.destroy', [$image])}}" class="js-image-destroy">delete</a>
    </div>
    <?php endforeach; ?>
</div>
