<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 05.11.18
 * Time: 18:18
 */
declare(strict_types=1);


namespace App\Http\Controllers\Cp;


use App\Http\Controllers\Controller;
use App\Models\City;

/**
 * Class CityController
 * @package App\Http\Controllers\Cp
 */
class CityController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $models = City::all();
        return view('cp/city/index', ['models' => $models]);
    }
}