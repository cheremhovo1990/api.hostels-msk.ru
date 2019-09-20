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
use App\Http\Requests\Cp\LodgeRequest;
use App\Models\MetroStation;
use App\Models\Organization\Lodge;
use App\Models\Organization\LodgeMetroStation;
use App\Models\Pagination\Detail\Detail;
use App\Models\Repositories\ImageRepository;
use App\Models\Organization\Repositories\LodgeRepository;
use App\Models\Organization\Repositories\OrganizationRepository;
use Illuminate\Http\Request;
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
     * @var LodgeRepository
     */
    private $lodgeRepository;
    /**
     * @var ImageRepository
     */
    private $imageRepository;

    /**
     * DetailController constructor.
     * @param OrganizationRepository $organizationRepository
     * @param LodgeRepository $lodgeRepository
     * @param ImageRepository $imageRepository
     */
    public function __construct(
        OrganizationRepository $organizationRepository,
        LodgeRepository $lodgeRepository,
        ImageRepository $imageRepository
    )
    {
        $this->organizationRepository = $organizationRepository;
        $this->lodgeRepository = $lodgeRepository;
        $this->imageRepository = $imageRepository;
    }




    public function index(Request $request)
    {
        $query = $models = Detail::query();

        if ($request->has('organization')) {
            $query
                ->join('detail_organization', 'detail_organization.detail_id', '=', 'details.id')
                ->join('detail_organizations', 'detail_organization.organization_id', '=', 'detail_organizations.id')
                ->where('detail_organizations.organization_id', '=', $request->get('organization'));
        }
        if ($request->has('station')) {

        }
        $models = $query->get();

        $stations = MetroStation::all();
        $groupStation = $stations->groupBy('line_name');
        return view('cp.detail.index', ['models' => $models, 'groupStation' => $groupStation]);
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
            'lodge' => null,
            'statusDropDown' => LodgeHelper::getStatusDropDown(),
            'cityDropDown' => CityHelper::getDropDown()
        ]);
    }

    /**
     * @param Detail $detail
     * @param LodgeRequest $lodgeRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Detail $detail, LodgeRequest $lodgeRequest)
    {
        $organization = $this->organizationRepository->oneByDetail($detail->id);
        $data = $lodgeRequest->validated();
        DB::transaction(function () use ($data, $organization, $detail) {
            $lodge = Lodge::newForDetail($data, $organization);
            $lodge->saveOrFail();
            $lodge->detail()->save($detail);
            if (isset($data['stations'])) {
                foreach ($data['stations'] as $station) {
                    $lodgeMetroStation = LodgeMetroStation::new($lodge->id, $station['id'], $station['distance']);
                    $lodgeMetroStation->save();
                }
            }
            $this->imageRepository->update($lodge, $data['image_token'], Lodge::IMAGE_TOKEN);
        });

        return redirect(route('cp.organizations.show', [$organization]));
    }

    /**
     * @param Detail $detail
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Detail $detail)
    {

        $lodge = Lodge::where('id', $detail->lodge_id)->first();
        return view(
            'cp/detail/edit', [
            'detail' => $detail,
            'lodge' => $lodge,
            'statusDropDown' => LodgeHelper::getStatusDropDown(),
            'cityDropDown' => CityHelper::getDropDown()
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
        $organization = $this->organizationRepository->findOne($lodge->organization_id);
        $data = $lodgeRequest->validated();
        $lodge->edit($data);
        $lodge->saveOrFail();
        return redirect(route('cp.organizations.show', [$organization]));
    }

    /**
     * @param Detail $detail
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function destroy(Detail $detail)
    {
        $lodge = $this->lodgeRepository->findOne($detail->lodge_id);
        $organization = $this->organizationRepository->findOne($lodge->organization_id);
        $lodge->delete();
        $detail->lodge_id = null;
        $detail->saveOrFail();
        return redirect(route('cp.organizations.show', [$organization]));
    }
}
