<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 02.03.19
 * Time: 15:18
 */
declare(strict_types=1);


namespace App\Models\Organization;


use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public $timestamps = false;

    public function getGroup()
    {
        $this->belongsTo(PropertyGroup::class, 'group_id', 'id');
    }
}