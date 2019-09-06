<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 04.11.18
 * Time: 18:01
 */
declare(strict_types=1);


namespace App\Helpers;


use App\Models\City;
use Illuminate\Support\Collection;

class CityHelper
{
    public static function getDropDown(): Collection
    {
        return City::pluck('name', 'id');
    }
}