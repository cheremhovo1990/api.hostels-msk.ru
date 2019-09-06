<?php

namespace App\Models\Pagination;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pagination
 * @package App
 * @property $id
 * @property $href
 * @property $parsed
 */
class Pagination extends Model
{
    protected $table = 'pagination';

    public $guarded = [];

    public function parsed()
    {
        $this->parsed = 1;
    }

    public function notParsed()
    {
        $this->parsed = 0;
    }
}
