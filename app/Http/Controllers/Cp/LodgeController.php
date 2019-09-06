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
use App\Helpers\LodgeHelper;
use App\Http\Requests\Cp\LodgeRequest;
use App\Models\Organization\Lodge;
use App\Models\Organization\Repositories\OrganizationRepository;
use App\Models\Organization\Repositories\PropertyGroupRepository;
use App\Services\LodgeService;

/**
 * Class LodgeController
 * @package App\Http\Controllers\Cp
 */
class LodgeController
{
    /**
     * @var PropertyGroupRepository
     */
    private $propertyGroupRepository;
    /**
     * @var LodgeService
     */
    private $lodgeService;

    /**
     * LodgeController constructor.
     * @param PropertyGroupRepository $propertyGroupRepository
     * @param LodgeService $lodgeService
     */
    public function __construct(
        PropertyGroupRepository $propertyGroupRepository,
        LodgeService $lodgeService
    )
    {
        $this->propertyGroupRepository = $propertyGroupRepository;
        $this->lodgeService = $lodgeService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $models = Lodge::orderBy('id', 'desc')->paginate();

        return view('cp/lodge/index', ['models' => $models]);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('cp/lodge/create',
            [
                'model' => null,
                'cityDropDown' => CityHelper::getDropDown(),
                'statusDropDown' => LodgeHelper::getStatusDropDown(),
                'organizationDropDown' => OrganizationRepository::getDropDown(),
                'groups' => $this->propertyGroupRepository->findAll(),
            ]
        );
    }

    public function store(LodgeRequest $lodgeRequest)
    {
        $data = $lodgeRequest->validated();
        $this->lodgeService->create($data);

        return redirect(route('cp.lodges.index'));
    }

    /**
     * @param Lodge $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Lodge $model)
    {
        return view('cp/lodge/edit', [
            'model' => $model,
            'cityDropDown' => CityHelper::getDropDown(),
            'statusDropDown' => LodgeHelper::getStatusDropDown(),
            'organizationDropDown' => OrganizationRepository::getDropDown(),
            'groups' => $this->propertyGroupRepository->findAll(),
        ]);
    }

    /**
     * @param Lodge $lodge
     * @param LodgeRequest $lodgeRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function update(Lodge $lodge, LodgeRequest $lodgeRequest)
    {
        $data = $lodgeRequest->validated();
        $this->lodgeService->update($lodge, $data);

        return redirect(route('cp.lodges.index'));
    }
}