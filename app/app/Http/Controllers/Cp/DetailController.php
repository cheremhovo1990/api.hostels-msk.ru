<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 03.11.18
 * Time: 10:38
 */
declare(strict_types=1);


namespace App\Http\Controllers\Cp;


use App\Helpers\CityHelper;
use App\Helpers\LodgeHelper;
use App\Http\Requests\Cp\DetailRequest;
use App\Models\Pagination\Detail\Detail;

/**
 * Class DetailController
 * @package App\Http\Controllers\Cp
 */
class DetailController
{
    /**
     * @param Detail $detail
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Detail $detail)
    {
        return view(
            'cp/detail/create', [
            'detail' => $detail,
            'statusDropDown' => LodgeHelper::getStatusDropDown(),
            'cityDropDown' => CityHelper::getDropDown()
        ]);
    }

    public function store(DetailRequest $detailRequest)
    {
        var_dump($detailRequest->validated());
    }
}