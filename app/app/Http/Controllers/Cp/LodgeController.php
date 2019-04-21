<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 23.12.18
 * Time: 12:16
 */
declare(strict_types=1);


namespace App\Http\Controllers\Cp;


use App\Helpers\CityHelper;
use App\Models\Organization\Lodge;

/**
 * Class LodgeController
 * @package App\Http\Controllers\Cp
 */
class LodgeController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $models = Lodge::paginate();

        return view('cp/lodge/index', ['models' => $models]);
    }

    /**
     * @param Lodge $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Lodge $model)
    {
        return view('cp/lodge/edit', [
            'model' => $model,
            'cityDropDown' => CityHelper::getDropDown()
        ]);
    }

    public function update()
    {
        return redirect(route('cp.lodges.index'));
    }
}