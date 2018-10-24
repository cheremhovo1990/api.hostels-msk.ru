<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 18.10.18
 * Time: 7:52
 */
declare(strict_types=1);


namespace App\Models\Pagination\Detail;


use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'detail_reviews';
    protected $guarded = [];
}