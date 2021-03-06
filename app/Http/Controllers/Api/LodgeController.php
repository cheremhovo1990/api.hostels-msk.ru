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
use App\Http\Resources\Lodge as LodgeResource;
use App\Http\Resources\LodgeCollection;
use App\Models\Organization\Lodge;
use App\Models\Organization\Repositories\LodgeRepository;
use Illuminate\Http\Request;

/**
 * Class LodgeController
 * @package App\Http\Controllers\Api
 */
class LodgeController extends Controller
{
    /**
     * @var LodgeRepository
     */
    private $lodgeRepository;

    /**
     * LodgeController constructor.
     * @param LodgeRepository $lodgeRepository
     */
    public function __construct(
        LodgeRepository $lodgeRepository
    )
    {
        $this->lodgeRepository = $lodgeRepository;
    }

    /**
     * @param Request $request
     * @return LodgeCollection
     */
    public function index(Request $request)
    {
        $params = $request->json();

        if ($params->has('metro-station')) {
            $models = $this->lodgeRepository->searchWithPaginate($params);
        } else {
            $models = $this->lodgeRepository->getPagination();
        }

        return new LodgeCollection($models);
    }

    /**
     * @param Request $request
     * @return LodgeCollection
     */
    public function all(Request $request)
    {
        $params = $request->json();

        if (is_null($params)) {
            $models = $this->lodgeRepository->all();
        } else {
            $models = $this->lodgeRepository->search($params);
        }

        return new LodgeCollection($models);
    }

    public function show(Lodge $lodge)
    {
        return new LodgeResource($lodge);
    }
}