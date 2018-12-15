<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 03.11.18
 * Time: 10:38
 */
declare(strict_types=1);


namespace App\Http\Controllers\Cp;


use App\Helpers\CityHelper;
use App\Helpers\LodgeHelper;
use App\Http\Requests\Cp\DetailRequest;
use App\Models\Organization\Lodge;
use App\Models\Organization\LodgeMetroStation;
use App\Models\Pagination\Detail\Detail;
use App\Models\Repositories\OrganizationRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class DetailController
 * @package App\Http\Controllers\Cp
 */
class DetailController
{
    /**
     * @var OrganizationRepository
     */
    private $organizationRepository;

    /**
     * DetailController constructor.
     * @param OrganizationRepository $organizationRepository
     */
    public function __construct(
        OrganizationRepository $organizationRepository
    )
    {
        $this->organizationRepository = $organizationRepository;
    }


    /**
     * @param Detail $detail
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Detail $detail)
    {
        return view(
            'cp/detail/create', [
            'detail' => $detail,
            'statusDropDown' => LodgeHelper::getStatusDropDown(),
            'cityDropDown' => CityHelper::getDropDown()
        ]);
    }

    /**
     * @param Detail $detail
     * @param DetailRequest $detailRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Detail $detail, DetailRequest $detailRequest)
    {
        $organization = $this->organizationRepository->oneByDetail($detail->id);
        $data = $detailRequest->validated();
        DB::transaction(function () use ($data, $organization, $detail) {
            $lodge = Lodge::new($data, $organization);
            $lodge->saveOrFail();
            //$lodge->detail()->save($detail);
            if (isset($data['stations'])) {
                foreach ($data['stations'] as $station) {
                    $lodgeMetroStation = LodgeMetroStation::new($lodge->id, $station['id'], $station['distance']);
                    $lodgeMetroStation->save();
                }
            }
        });

        return redirect(route('cp.organizations.show', [$organization]));
    }
}