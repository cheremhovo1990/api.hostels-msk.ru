<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 05.11.18
 * Time: 17:22
 */
declare(strict_types=1);


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Metro
 * @package App\Models
 * @property $id
 * @property $name
 * @property $hex_color
 * @property $line_name
 * @property $order
 * @property $latitude
 * @property $longitude
 */
class Metro extends Model
{
    protected $guarded = [];
    /**
     * @var string
     */
    protected $table = 'metro_stations';
}