<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 16.11.18
 * Time: 20:02
 */
declare(strict_types=1);


namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Municipality
 * @package App\Models
 *
 * @method static byLatitudeLongitude($latitude, $longitude)
 *
 * @property $id
 * @property $administrative_distance
 * @property $name
 * @property $geometry
 *
 * @property District $district
 */
class Municipality extends Model
{
    /**
     * @var string
     */
    protected $table = 'municipalities';

    /**
     * @var array
     */
    protected $casts = [
        'geometry' => 'array',
    ];

    protected $guarded = [];

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


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'administrative_district_id', 'id');
    }
}