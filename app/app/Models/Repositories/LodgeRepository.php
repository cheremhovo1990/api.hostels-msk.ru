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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
     * @return Collection|Lodge[]
     */
    public function search(ParameterBag $params): Collection
    {
        $query = $this->querySearch($params);
        return $query->get();
    }

    /**
     * @param ParameterBag $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchWithPaginate(ParameterBag $params)
    {
        $query = $this->querySearch($params);
        return $query->paginate();
    }

    /**
     * @param ParameterBag $params
     * @return Builder
     */
    public function querySearch(ParameterBag $params): Builder
    {
        $query = Lodge::query()->with(['organization']);
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
        return $query;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function get()
    {
        return Lodge::paginate();
    }

    /**
     * @return Lodge[]|Collection
     */
    public function all()
    {
        return Lodge::all();
    }
}