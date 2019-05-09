<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 09.05.19
 * Time: 12:28
 */
declare(strict_types=1);


namespace App\Helpers;

use App\Models\Meta;

/**
 * Class MetaHelper
 * @package App\Helpers
 */
class MetaHelper
{
    /**
     * @return array
     */
    public static function getDropDown()
    {
        return [
            Meta::PAGE_IDENTITY_METRO_MAIN => Meta::PAGE_IDENTITY_METRO_MAIN,
            Meta::PAGE_IDENTITY_METRO => Meta::PAGE_IDENTITY_METRO,
        ];
    }
}