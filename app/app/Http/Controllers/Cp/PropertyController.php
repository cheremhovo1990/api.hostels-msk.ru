<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 10.05.19
 * Time: 11:11
 */
declare(strict_types=1);


namespace App\Http\Controllers\Cp;


use App\Helpers\GroupHelper;
use App\Http\Requests\Cp\PropertyRequest;
use App\Models\Organization\Property;

/**
 * Class PropertyController
 * @package App\Http\Controllers\Cp
 */
class PropertyController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $models = Property::paginate();
        return view('cp.property.index', [
            'models' => $models,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('cp.property.create', [
            'model' => null,
            'groupDropDown' => GroupHelper::dropDown(),
        ]);
    }

    /**
     * @param PropertyRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PropertyRequest $request)
    {
        Property::create($request->validated());
        return redirect(route('cp.properties.index'));
    }

    /**
     * @param Property $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Property $model)
    {
        return view('cp.property.edit', [
            'model' => $model,
            'groupDropDown' => GroupHelper::dropDown(),
        ]);
    }

    /**
     * @param Property $model
     * @param PropertyRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function update(Property $model, PropertyRequest $request)
    {
        $model->fill($request->validated());
        $model->saveOrFail();
        return redirect(route('cp.properties.index'));
    }
}