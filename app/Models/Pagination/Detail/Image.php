<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 14.10.18
 * Time: 17:39
 */
declare(strict_types=1);


namespace App\Models\Pagination\Detail;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Image
 * @package App\Models\Pagination\Detail
 * @property $href
 * @property $src
 */
class Image extends Model
{
    protected $table = 'detail_images';
    protected $guarded = [];
}