<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 13.01.19
 * Time: 8:46
 */
declare(strict_types=1);


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\LodgeCollection;
use App\Models\Organization\Lodge;

/**
 * Class LodgeController
 * @package App\Http\Controllers\Api
 */
class LodgeController extends Controller
{
    /**
     * @return LodgeCollection
     */
    public function index()
    {
        return new LodgeCollection(Lodge::paginate());
    }
}