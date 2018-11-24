<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 24.11.18
 * Time: 16:03
 */

/** @var $images \App\Models\Image[] */

?>

<div class="row">
    <?php foreach ($images as $image): ?>
    <div class="col-md-3">
        <img src="/uploads/lodge/<?= $image->getUrl(160) ?>" alt="">
    </div>
    <?php endforeach; ?>
</div>
