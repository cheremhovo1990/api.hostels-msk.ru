<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 10.05.19
 * Time: 8:02
 */
declare(strict_types=1);


namespace App\Models\Repositories;


use App\Models\MetroStation;

/**
 * Class MetroStationRepository
 * @package App\Models\Repositories
 */
class MetroStationRepository
{
    /**
     * @param $id
     * @return MetroStation|null
     */
    public function findOne($id): ?MetroStation
    {
        return MetroStation::where('id', '=', $id)->first();
    }
}