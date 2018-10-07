<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pagination
 * @package App
 * @property $id
 */
class Pagination extends Model
{
    protected $table = 'pagination';

    public $guarded = [];
}
