<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 23.12.18
 * Time: 12:16
 */
declare(strict_types=1);


namespace App\Http\Controllers\Cp;


use App\Models\Organization\Lodge;

class LodgeController
{
    public function index()
    {
        $models = Lodge::paginate();

        return view('cp/lodge/index', ['models' => $models]);
    }
}