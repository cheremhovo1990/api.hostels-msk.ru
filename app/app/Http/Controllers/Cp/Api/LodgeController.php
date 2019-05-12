<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 24.11.18
 * Time: 8:20
 */
declare(strict_types=1);


namespace App\Http\Controllers\Cp\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

/**
 * Class LodgeController
 * @package App\Http\Controllers\Cp\Api
 */
class LodgeController extends Controller
{

    /**
     * @param \App\Models\Image $image
     * @throws \Exception
     */
    public function destroyImage(\App\Models\Image $image)
    {
        $image->delete();
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewImages($token)
    {
        $images = \App\Models\Image::where('token', $token)->get();

        return view('cp/api/lodge/view-images', ['images' => $images]);
    }

    /**
     * @param Request $request
     * @param $token
     * @throws \Throwable
     */
    public function storeImage(Request $request, $token)
    {
        $file = $request->file('image');
        $this->store($file, $token);
    }

    /**
     * @param Request $request
     * @param $token
     * @throws \Throwable
     */
    public function storeImages(Request $request, $token)
    {
        /** @var UploadedFile[] $files */
        $files = $request->file('images');
        foreach ($files as $file) {
            $this->store($file, $token);
        }
    }

    /**
     * @param UploadedFile $file
     * @param $token
     * @throws \Throwable
     */
    protected function store(UploadedFile $file, $token)
    {
        $model = \App\Models\Image::newForLodge($token, $file->extension());
        $model->saveOrFail();
        $pathFullOriginal = $file->storeAs($model->getFolderOriginal(), $model->getFullName(), ['disk' => 'uploads']);
        $image = Image::make(public_path(\App\Models\Image::ROOT_FOLDER . '/' . $pathFullOriginal));
        $ratio = $image->width() / $image->height();
        $width = \App\Models\Image::WIDTH;
        $image->fit($width, ceil($width / $ratio))
            ->save(public_path(\App\Models\Image::ROOT_FOLDER . '/' . $model->getPath($width)));
    }
}