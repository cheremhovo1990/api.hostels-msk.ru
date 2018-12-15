<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 15.12.18
 * Time: 11:34
 */
declare(strict_types=1);


namespace App\Models\Organization;


use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class LodgeMetroStation
 * @package App\Models\Organization
 *
 * @property $lodge_id
 * @property $metro_station_id
 * @property $distance
 */
class LodgeMetroStation extends Pivot
{
    /**
     * @var string
     */
    protected $table = 'lodge_metro_station';

    /**
     * @param $lodgeId
     * @param $stationId
     * @param $distance
     * @return LodgeMetroStation
     */
    public static function new($lodgeId, $stationId, $distance): self
    {
        $model = new static();
        $model->lodge_id = $lodgeId;
        $model->metro_station_id = $stationId;
        $model->distance = $distance;
        return $model;
    }
}