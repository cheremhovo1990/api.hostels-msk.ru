<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 10.05.19
 * Time: 12:15
 */
declare(strict_types=1);


namespace App\Helpers;


use App\Models\Organization\PropertyGroup;

/**
 * Class GroupHelper
 * @package App\Helpers
 */
class GroupHelper
{

    /**
     * @return mixed
     */
    public static function dropDown()
    {
        return PropertyGroup::pluck('name', 'id');
    }
}