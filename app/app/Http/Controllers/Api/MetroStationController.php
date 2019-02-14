<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 10.02.19
 * Time: 12:17
 */
declare(strict_types=1);


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\MetroStationCollection;
use App\Models\MetroStation;

/**
 * Class MetroController
 * @package App\Http\Controllers\Api
 */
class MetroStationController extends Controller
{
    /**
     * @return MetroStationCollection
     */
    public function all()
    {
        return new MetroStationCollection(MetroStation::all());
    }
}