<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 09.05.19
 * Time: 11:45
 */
declare(strict_types=1);


namespace App\Http\Controllers\Cp;


use App\Helpers\MetaHelper;
use App\Http\Requests\Cp\MetaRequest;
use App\Models\Meta;

/**
 * Class MetaController
 * @package App\Http\Controllers\Cp
 */
class MetaController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $models = Meta::paginate();

        return view('cp.meta.index',
            [
                'models' => $models,
            ]
        );
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('cp.meta.create', [
            'model' => null,
            'pageIdentityDropDown' => MetaHelper::getDropDown(),
        ]);
    }


    /**
     * @param MetaRequest $metaRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(MetaRequest $metaRequest)
    {
        $data = $metaRequest->validated();
        Meta::create($data);
        return redirect(route('cp.meta.index'));
    }

    /**
     * @param Meta $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Meta $model)
    {
        return view('cp.meta.edit', [
                'model' => $model,
                'pageIdentityDropDown' => MetaHelper::getDropDown(),
            ]
        );
    }

    /**
     * @param Meta $model
     * @param MetaRequest $metaRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Meta $model, MetaRequest $metaRequest)
    {
        $data = $metaRequest->validated();
        $model->fill($data);
        $model->saveOrFail();
        return redirect(route('cp.meta.index'));
    }
}