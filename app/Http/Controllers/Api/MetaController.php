<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 09.05.19
 * Time: 16:59
 */
declare(strict_types=1);


namespace App\Http\Controllers\Api;


use App\Models\Meta;
use App\Models\Repositories\MetaRepository;
use App\Models\Repositories\MetroStationRepository;
use App\Services\ToolService;
use Illuminate\Http\Request;

/**
 * Class MetaController
 * @package App\Http\Controllers\Api
 */
class MetaController
{
    /**
     * @var ToolService
     */
    private $toolService;
    /**
     * @var MetroStationRepository
     */
    private $metroStationRepository;
    /**
     * @var MetaRepository
     */
    private $metaRepository;

    /**
     * MetaController constructor.
     * @param ToolService $toolService
     * @param MetroStationRepository $metroStationRepository
     * @param MetaRepository $metaRepository
     */
    public function __construct(
        ToolService $toolService,
        MetroStationRepository $metroStationRepository,
        MetaRepository $metaRepository
    )
    {
        $this->toolService = $toolService;
        $this->metroStationRepository = $metroStationRepository;
        $this->metaRepository = $metaRepository;
    }

    /**
     * @param $identify
     * @return \App\Http\Resources\Meta
     */
    public function metroMain()
    {
        $meta = $this->metaRepository->findOneByPageIdentify(Meta::PAGE_IDENTITY_METRO_MAIN);
        return (new \App\Http\Resources\Meta($meta));
    }

    /**
     * @param Request $request
     * @return \App\Http\Resources\Meta
     */
    public function metro(Request $request)
    {
        $metro_id = $request->get('metro_id');
        $metro = $this->metroStationRepository->findOne($metro_id);
        $this->toolService->notFound($metro);
        $name = $metro->name;
        $meta = $this->metaRepository->findOneByPageIdentify(Meta::PAGE_IDENTITY_METRO);
        $meta->title = str_replace('{metro}', $name, $meta->title);
        $meta->description = str_replace('{metro}', $name, $meta->description);
        $meta->h1 = str_replace('{metro}', $name, $meta->h1);
        return (new \App\Http\Resources\Meta($meta));
    }
}