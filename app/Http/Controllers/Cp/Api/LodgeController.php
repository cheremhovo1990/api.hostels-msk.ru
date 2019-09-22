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
use App\Models\Organization\Lodge;
use App\Models\Organization\Repositories\LodgeRepository;
use App\Models\Repositories\ImageRepository;
use App\Services\Text\Generate;
use App\Services\Text\Service;
use App\Services\ToolService;
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
    /**
     * @var Service
     */
    private $generate;


    public function __construct(
        LodgeRepository $lodgeRepository,
        ImageRepository $imageRepository,
        Service $generate,
        ToolService $toolService
    )
    {
        $this->lodgeRepository = $lodgeRepository;
        $this->imageRepository = $imageRepository;
        $this->toolService = $toolService;
        $this->generate = $generate;
    }

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
        $lodge = $this->lodgeRepository->findOneByImageToken($token);
        $file = $request->file('image', $lodge);
        $this->store($file, $token);
    }

    /**
     * @param Request $request
     * @param $token
     * @throws \Throwable
     */
    public function storeImages(Request $request, $token)
    {
        $lodge = $this->lodgeRepository->findOneByImageToken($token);

        /** @var UploadedFile[] $files */
        $files = $request->file('images');
        foreach ($files as $file) {
            $this->store($file, $token, $lodge);
        }
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Throwable
     */
    public function imageMain(Request $request)
    {
        $image = $this->imageRepository->findOne($request->get('id'));
        $this->toolService->notFound($image);
        $this->imageRepository->resetMain($image->token);
        $image->status = \App\Models\Image::STATUS_MAIN;
        $image->saveOrFail();
        return ['success' => true];
    }

    /**
     * @param UploadedFile $file
     * @param $token
     * @param Lodge|null $lodge
     * @throws \Throwable
     */
    protected function store(UploadedFile $file, $token, Lodge $lodge = null)
    {
        if (is_null($lodge)) {
            $model = \App\Models\Image::newForLodge($token, $file->extension());
        } else {
            $model = \App\Models\Image::newForLodge($token, $file->extension(), $lodge->id, \App\Models\Organization\Lodge::IMAGE_TOKEN);
        }

        $model->saveOrFail();
        $pathFullOriginal = $file->storeAs($model->getFolderOriginal(), $model->getFullName(), ['disk' => 'uploads']);
        $image = Image::make(public_path(\App\Models\Image::ROOT_FOLDER . '/' . $pathFullOriginal));
        $ratio = $image->width() / $image->height();
        $width = \App\Models\Image::WIDTH;
        $image->fit($width, ceil($width / $ratio))
            ->save(public_path(\App\Models\Image::ROOT_FOLDER . '/' . $model->getPath($width)));
    }

    public function generateText(Lodge $lodge): array
    {
        $text = $this->generate->announce($lodge, 1);
        return [
            'success' => true,
            'text' => $text,
        ];
    }
}
