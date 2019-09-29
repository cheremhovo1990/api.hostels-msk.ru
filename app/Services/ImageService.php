<?php

declare(strict_types=1);


namespace App\Services;


use App\Models\Image;
use App\Models\Organization\Lodge;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

/**
 * Class ImageService
 * @package App\Services
 */
class ImageService
{
    /**
     * @param $token
     * @param UploadedFile $file
     * @return Image
     */
    public function createByToken($token, UploadedFile $file): Image
    {
        $path = 'uploads/lodge/' . Carbon::now()->format('Y-m');
        $name = strtolower(md5(uniqid())) . '.' . $file->extension();
        $file->storeAs($path, $name, ['disk' => 'uploads']);

        $image = Image::create([
            'token' => $token,
            'src' => $path . '/' . $name
        ]);
        return $image;
    }

    public function createByLodge(Lodge $lodge, UploadedFile $file)
    {
        $path = 'uploads/lodge/' . Carbon::now()->format('Y-m');
        $name = strtolower(md5(uniqid())) . '.' . $file->extension();
        $file->storeAs($path, $name, ['disk' => 'uploads']);
        $image = Image::make([
            'src' => $path . '/' . $name
        ]);
        $lodge->images()->save($image);
    }
}
