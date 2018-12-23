<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 23.12.18
 * Time: 11:06
 */
declare(strict_types=1);


namespace App\Models\Repositories;


use App\Models\Organization\Lodge;

/**
 * Class LodgeRepository
 * @package App\Models\Repositories
 */
class LodgeRepository
{
    /**
     * @param int $id
     * @return Lodge|null
     */
    public function findOne(int $id): ?Lodge
    {
        return Lodge::where('id', $id)->first();
    }
}