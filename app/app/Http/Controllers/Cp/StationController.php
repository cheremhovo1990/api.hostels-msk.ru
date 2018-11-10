<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 05.11.18
 * Time: 18:37
 */
declare(strict_types=1);


namespace App\Http\Controllers\Cp;


use App\Models\Metro;
use Illuminate\Routing\Controller;

/**
 * Class StationController
 * @package App\Http\Controllers\Cp
 */
class StationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $models = Metro::all();
        return view('cp/station/index', ['models' => $models]);
    }
}