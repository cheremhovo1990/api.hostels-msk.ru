<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 28.10.18
 * Time: 15:51
 */
declare(strict_types=1);


namespace App\Helpers;


use App\Models\Organization\Organization;
use Illuminate\Support\Collection;

/**
 * Class OrganizationHelper
 * @package App\Helpers
 */
class OrganizationHelper
{
    public static function getNameDropDown(): array
    {
        return [
            Organization::STATUS_DISABLE => 'Disable',
            Organization::STATUS_ENABLE => 'Enable',
        ];
    }

    public static function getDropDown(): Collection
    {
        return Organization::pluck('name', 'id');
    }
}
