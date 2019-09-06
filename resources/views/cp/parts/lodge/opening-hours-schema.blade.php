<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 02.12.18
 * Time: 11:23
 */

/** @var $opening_hour */

?>

<div class="form-group">
    <div class="input-group">
        <input type="text" class="form-control" name="schema_org_opening_hours[]" value="{{ $opening_hour ?? null }}">
        <div class="input-group-append">
            <button class="btn delete-input-opening-hours-schema">Delete</button>
        </div>
    </div>

</div>
