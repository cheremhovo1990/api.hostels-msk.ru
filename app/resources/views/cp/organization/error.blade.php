<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 03.11.18
 * Time: 7:47
 */

?>

@foreach($errors->all() as $error)
    <p class="text-danger">{{$error}}</p>
@endforeach
