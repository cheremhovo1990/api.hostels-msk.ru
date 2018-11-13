<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 10.11.18
 * Time: 12:14
 */
declare(strict_types=1);


namespace App\Services;


use App\Models\Metro;
use Illuminate\Support\Collection;

/**
 * Class MetroDistanceService
 * @package App\Services
 */
class MetroDistanceService
{
    /**
     * @param float $longitude
     * @param float $latitude
     * @param int $distance
     * @param int $angle
     * @param string|null $type
     * @return array|mixed
     */
    public function getPoint(float $longitude, float $latitude, int $distance, int $angle, string $type): float
    {
        // Длина дуги параллели в 1° на экваторе в метрах
        $latMeter = 111321;
        $angle = deg2rad($angle);

        $dx = $distance / ($latMeter * cos(deg2rad($latitude))) * cos($angle);
        $dy = $distance / $latMeter * sin($angle);

        $result = [
            'longitude' => $longitude + $dx,
            'latitude' => $latitude + $dy
        ];

        return $result[$type];
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param int $distance
     * @return mixed
     */
    public function getMetro(float $latitude, float $longitude, int $distance): Collection
    {

        $sLng = $this->getPoint($longitude, $latitude, $distance, 180, 'longitude');
        $eLng = $this->getPoint($longitude, $latitude, $distance, 0, 'longitude');
        $sLat = $this->getPoint($longitude, $latitude, $distance, 270, 'latitude');
        $eLat = $this->getPoint($longitude, $latitude, $distance, 90, 'latitude');
        $stations = Metro::whereBetween('latitude', [$sLat, $eLat])
            ->whereBetween('longitude', [$sLng, $eLng])
            ->get();
        return $stations;
    }


    /**
     * @param $latitude
     * @param $longitude
     * @param Metro $station
     * @return float
     */
    public function distance(float $latitude, float $longitude, Metro $station): float
    {

        // Средний радиус Земли в метрах
        $earthRadius = 6372797;

        $dLat = deg2rad($station->latitude - $latitude);
        $dLon = deg2rad($station->longitude - $longitude);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude)) * cos(deg2rad($station->latitude)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));
        $distance = ceil($earthRadius * $c);

        return $distance;
    }
}