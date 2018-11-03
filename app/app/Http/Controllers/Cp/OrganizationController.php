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

/**
 * Class OrganizationController
 * @package App\Http\Controllers\Cp
 */
class OrganizationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $organizations = Organization::orderBy('id', 'desc')->paginate();

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
        $details = Detail::leftJoin('detail_organization', 'detail_organization.detail_id', '=', 'details.id')
            ->leftJoin('detail_organizations', 'detail_organizations.id', '=', 'detail_organization.organization_id')
            ->where('detail_organizations.organization_id', '=', $organization->id)
            ->paginate();

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