<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 04.11.18
 * Time: 18:02
 */
declare(strict_types=1);


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


/**
 * Class City
 * @package App\Models
 * @property $name
 *
 * @property CityHhArea $hhArea
 */
class City extends Model
{
    /**
     *
     */
    public function hhArea()
    {
        return $this->hasOne(CityHhArea::class);
    }
}