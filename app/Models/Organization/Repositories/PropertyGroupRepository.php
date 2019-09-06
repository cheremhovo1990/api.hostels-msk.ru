<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 10.05.19
 * Time: 14:18
 */
declare(strict_types=1);


namespace App\Models\Organization\Repositories;


use App\Models\Organization\PropertyGroup;

/**
 * Class PropertyGroupRepository
 * @package App\Models\Organization\Repositories
 */
class PropertyGroupRepository
{
    /**
     * @return PropertyGroup[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findAll()
    {
        return PropertyGroup::all();
    }
}