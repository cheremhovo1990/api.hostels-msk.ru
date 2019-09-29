<?php

declare(strict_types=1);


namespace App\Http\Controllers;


use App\Models\Image;
use App\Services\ToolService;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    /**
     * @var ToolService
     */
    private $toolService;

    public function __construct(ToolService $toolService)
    {

        $this->toolService = $toolService;
    }


    public function view($path)
    {
        abort_if(false == preg_match('~^(?<path>.+)\.(?<size>\w+)\.(?<extension>\w{3,4})$~', $path, $match), 404);
        $image = Image::query()->where('src', '=', "/uploads/{$match['path']}.{$match['extension']}")->first();
        $this->toolService->notFound($image);
        $image = \Intervention\Image\Facades\Image::make(public_path($image->src));
        if (preg_match('~^(?<width>\d{3,4})x(?<height>\d{3,4})$~', $match['size'], $matchSize)) {
            ['width' => $width, 'height' => $height] = $matchSize;
            $path = "/uploads/{$match['path']}.{$match['size']}.{$match['extension']}";
        } elseif (preg_match('~^(?<width>\d{3,4})$~', $match['size'], $matchSize)) {
            $ratio = $image->width() / $image->height();
            $width = $matchSize['width'];
            $height = ceil($width / $ratio);
            $path = "/uploads/{$match['path']}.{$width}.{$match['extension']}";
        } else {
            abort(404);
        }
        $image->fit($width, $height)
            ->save(public_path($path));

        return response()->download(public_path($path), null, [], null);
    }
}
