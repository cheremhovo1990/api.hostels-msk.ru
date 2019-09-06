<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 10.05.19
 * Time: 9:07
 */
declare(strict_types=1);


namespace App\Http\Controllers\Cp;


use App\Http\Requests\Cp\PropertyGroupRequest;
use App\Models\Organization\PropertyGroup;

/**
 * Class PropertyGroupController
 * @package App\Http\Controllers\Cp
 */
class PropertyGroupController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $models = PropertyGroup::paginate();

        return view('cp.property-group.index', [
            'models' => $models,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('cp.property-group.create', [
            'model' => null,
        ]);
    }

    /**
     * @param PropertyGroupRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PropertyGroupRequest $request)
    {
        $data = $request->validated();
        PropertyGroup::create($data);
        return redirect(route('cp.property-groups.index'));
    }

    /**
     * @param PropertyGroup $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(PropertyGroup $model)
    {
        return view('cp.property-group.edit', [
            'model' => $model,
        ]);
    }

    /**
     * @param PropertyGroup $model
     * @param PropertyGroupRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function update(PropertyGroup $model, PropertyGroupRequest $request)
    {
        $model->fill($request->validated());
        $model->saveOrFail();
        return redirect(route('cp.property-groups.index'));
    }
}