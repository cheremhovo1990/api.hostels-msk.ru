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
use App\Services\ImageService;
use App\Services\LodgeService;
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
     * @var Service
     */
    private $generate;



    public function __construct(
        Service $generate

    )
    {
        $this->generate = $generate;
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
