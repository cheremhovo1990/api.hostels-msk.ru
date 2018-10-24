<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 09.10.18
 * Time: 20:33
 */
declare(strict_types=1);


namespace App\Models\Pagination\Detail;


use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $guarded = [];

    protected $table = 'detail_phones';
}