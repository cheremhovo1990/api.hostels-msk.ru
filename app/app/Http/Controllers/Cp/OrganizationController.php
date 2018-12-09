<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 27.10.18
 * Time: 17:44
 */
declare(strict_types=1);


namespace App\Http\Controllers\Cp;


use App\Helpers\OrganizationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cp\OrganizationRequest;
use App\Models\Organization\Organization;
use App\Models\Pagination\Detail\Detail;
use App\Models\Repositories\DetailRepository;
use Illuminate\Http\Request;

/**
 * Class OrganizationController
 * @package App\Http\Controllers\Cp
 */
class OrganizationController extends Controller
{
    /**
     * @var DetailRepository
     */
    private $detailRepository;

    /**
     * OrganizationController constructor.
     * @param DetailRepository $detailRepository
     */
    public function __construct(
        DetailRepository $detailRepository
    )
    {
        $this->detailRepository = $detailRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->get('id')) {
            $organizations = Organization::orderBy('id', $request->get('id'))->paginate();
            $organizations->appends(['id' => $request->get('id')]);
        } else {
            $organizations = Organization::orderBy('id', 'desc')->paginate();
        }


        return view('cp/organization/index', ['organizations' => $organizations]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('cp/organization/create', [
            'nameDropDown' => OrganizationHelper::getNameDropDown(),
        ]);
    }

    /**
     * @param OrganizationRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(OrganizationRequest $request)
    {
        $data = $request->validated();
        $model = Organization::create($data);
        return redirect(route('cp.organizations.show', ['id' => $model->id]));
    }

    /**
     * @param Organization $organization
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Organization $organization)
    {
        $details = $this->detailRepository->allByOrganization($organization->id);

        return view('cp/organization/show', ['model' => $organization, 'details' => $details]);
    }

    /**
     * @param Organization $organization
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect(route('cp.organizations.index'));
    }


    /**
     * @param Organization $organization
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Organization $organization)
    {
        return view('cp/organization/edit', [
            'model' => $organization,
            'nameDropDown' => OrganizationHelper::getNameDropDown(),
        ]);
    }

    /**
     * @param Organization $organization
     * @param OrganizationRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function update(Organization $organization, OrganizationRequest $request)
    {
        $data = $request->validated();
        $organization->fill($data);
        $organization->saveOrFail();
        return redirect(route('cp.organizations.show', ['id' => $organization->id]));
    }
}