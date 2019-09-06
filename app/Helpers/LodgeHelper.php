<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 04.11.18
 * Time: 16:16
 */
declare(strict_types=1);


namespace App\Helpers;


use App\Models\Organization\Lodge;

/**
 * Class LodgeHelper
 * @package App\Helpers
 */
class LodgeHelper
{
    /**
     * @return array
     */
    public static function getStatusDropDown(): array
    {
        return [
            Lodge::STATUS_DISABLE => 'Disable',
            Lodge::STATUS_ENABLE => 'Enable',
        ];
    }
}