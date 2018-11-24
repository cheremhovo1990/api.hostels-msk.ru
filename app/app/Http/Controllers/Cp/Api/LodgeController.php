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

class LodgeController extends Controller
{
    public function storeImages(Request $request, $token)
    {
        /** @var UploadedFile[] $files */
        $files = $request->file('images');
        foreach ($files as $file) {
            $this->store($file, $token);
        }
    }

    public function viewImages($token)
    {
        $images = \App\Models\Image::where('token', $token)->get();

        return view('cp/api/lodge/view-images', ['images' => $images]);
    }

    protected function store(UploadedFile $file, $token)
    {
        $model = new \App\Models\Image();
        $model->token = $token;
        $model->name = uniqid('', true);
        $model->extension = $file->extension();
        $model->saveOrFail();
        $pathFullOriginal = $file->storeAs('lodge/' . $model->getFolderOriginal(), $model->getFullName(), ['disk' => 'uploads']);
        $image = Image::make(public_path('uploads/' . $pathFullOriginal));
        $ratio = $image->width() / $image->height();
        $width = 160;
        $image->fit($width, ceil($width / $ratio))
            ->save(public_path('uploads/lodge/' . $model->getFolder($width)));
    }
}