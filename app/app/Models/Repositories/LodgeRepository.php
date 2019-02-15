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
use Symfony\Component\HttpFoundation\ParameterBag;

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

    /**
     * @param ParameterBag $params
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function search(ParameterBag $params)
    {
        $query = Lodge::query();
        if ($params->has('metro-station')) {
            $query->join(
                'lodge_metro_station',
                'lodge_metro_station.lodge_id',
                '=',
                'lodges.id'
            )->where(
                'lodge_metro_station.metro_station_id',
                '=',
                $params->get('metro-station')
            );
        }
        return $query->paginate();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function get()
    {
        return Lodge::paginate();
    }
}