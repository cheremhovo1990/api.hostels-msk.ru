<?php

declare(strict_types=1);


namespace App\Models\Organization;


use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public $primaryKey = 'lodge_id';
    public $timestamps = false;
}
