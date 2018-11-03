<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 27.10.18
 * Time: 11:47
 */
declare(strict_types=1);


namespace App\Models\Organization;


use Illuminate\Database\Eloquent\Model;

class Lodge extends Model
{
    protected $connection = 'mysql';
    const STATUS_DISABLE = 0;
    const STATUS_ENABLE = 1;
    protected $guarded = [];
}