<?php

declare(strict_types=1);


namespace App\Http\Controllers\Cp;


use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Organization\Repositories\LodgeRepository;
use App\Models\Repositories\ImageRepository;
use App\Services\ImageService;
use App\Services\ToolService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ImageController extends Controller
{
    /**
     * @var ImageService
     */
    private $imageService;
    /**
     * @var LodgeRepository
     */
    private $lodgeRepository;
    /**
     * @var ImageRepository
     */
    private $imageRepository;
    /**
     * @var ToolService
     */
    private $toolService;

    public function __construct(
        ImageService $imageService,
        LodgeRepository $lodgeRepository,
        ImageRepository $imageRepository,
        ToolService $toolService
    )
    {
        $this->imageService = $imageService;
        $this->lodgeRepository = $lodgeRepository;
        $this->imageRepository = $imageRepository;
        $this->toolService = $toolService;
    }


    public function viewImages(Request $request)
    {
        $lodge = null;
        if ($lodge_id = $request->get('lodge_id')) {
            $lodge = $this->lodgeRepository->findOne($lodge_id);
        }
        if (is_null($lodge)) {
            $images = \App\Models\Image::where('token', session()->getId())->get();
        } else {
            $images = $lodge->images;
        }

        return view('cp/image/view-images', ['images' => $images]);
    }

    public function storeImage(Request $request)
    {
        $lodge = null;
        if ($lodge_id = $request->get('lodge_id')) {
            $lodge = $this->lodgeRepository->findOne($lodge_id);
        }
        $file = $request->file('image', $lodge);
        if (is_null($lodge)) {
            $this->imageService->createByToken($request->session()->getId(), $file);
        } else {
            $this->imageService->createByLodge($lodge, $file);
        }
        return ['success' => true];
    }

    public function storeImages(Request $request)
    {
        $lodge = null;
        if ($lodge_id = $request->get('lodge_id')) {
            $lodge = $this->lodgeRepository->findOne($lodge_id);
        }

        /** @var UploadedFile[] $files */
        $files = $request->file('images');
        foreach ($files as $file) {
            if (is_null($lodge)) {
                $this->imageService->createByToken(session()->getId(), $file);
            } else {
                $this->imageService->createByLodge($lodge, $file);
            }

        }
        return ['success' => true];
    }

    public function imageMain(Request $request, Image $image)
    {
        $this->toolService->notFound($image);
        if (is_null($image->token)) {
            Image::query()
                ->where('model_id', '=', $image->model_id)
                ->where('model_type', '=', $image->model_type)
                ->update(['status' => Image::STATUS_NONE]);
        } else {
            Image::query()
                ->where('token', '=', $image->token)
                ->update(['status' => Image::STATUS_NONE]);
        }
        $image->status = Image::STATUS_MAIN;
        $image->saveOrFail();
        return ['success' => true];
    }


    /**
     * @param \App\Models\Image $image
     * @throws \Exception
     */
    public function destroyImage(\App\Models\Image $image)
    {
        $image->delete();
        return ['success' => true];
    }
}
