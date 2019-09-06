<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 03.05.19
 * Time: 11:25
 */
declare(strict_types=1);


namespace App\Http\Controllers\Cp\Api;


use App\Http\Controllers\Controller;
use App\Services\Text\Service;

class TextController extends Controller
{
    /**
     * @var Service
     */
    private $service;

    public function __construct(
        Service $service
    )
    {

        $this->service = $service;
    }


    /**
     * @param $lodge
     * @return array
     */
    public function generate($lodge)
    {
        return [
            'success' => true,
            'text' => $this->service->announce($lodge, 1)
        ];
    }
}