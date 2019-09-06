<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 16.11.18
 * Time: 7:37
 */
declare(strict_types=1);


namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class District
 * @package App\Models
 *
 * @method static byLatitudeLongitude($latitude, $longitude)
 *
 * @property $name
 */
class District extends Model
{
    /**
     * @var string
     */
    protected $table = 'administrative_districts';

    /**
     * @param Builder $query
     * @param $latitude
     * @param $longitude
     * @return Builder
     */
    public function scopeByLatitudeLongitude(Builder $query, float $latitude, float $longitude)
    {
        $geometry = [
            'type' => 'Point',
            'coordinates' => [
                $longitude,
                $latitude,
            ]
        ];
        return $query->whereRaw('ST_Contains(ST_GeomFromGeoJson(geometry), ST_GeomFromGeoJson(CAST(:geometry AS JSON)))', [':geometry' => json_encode($geometry)]);
    }
}