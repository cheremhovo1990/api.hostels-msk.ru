<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 14.10.18
 * Time: 14:26
 */
declare(strict_types=1);


namespace App\Models\Pagination\Detail;


use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    protected $table = 'detail_descriptions';
    protected $guarded = [];
}