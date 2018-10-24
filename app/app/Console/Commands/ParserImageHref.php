<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 15.10.18
 * Time: 19:43
 */
declare(strict_types=1);


namespace App\Console\Commands;


use App\Models\Pagination\Detail\Image;
use App\Services\DomService;
use Illuminate\Console\Command;

class ParserImageHref extends Command
{
    protected $signature = 'parser:image-href';
    /**
     * @var DomService
     */
    private $domService;

    public function __construct(DomService $domService)
    {
        parent::__construct();
        $this->domService = $domService;
    }


    public function handle()
    {
        $images = Image::whereNull('src')->get();
        foreach ($images as $image) {
            $this->imageSource($image);
        }
    }

    public function imageSource(Image $image)
    {
        $path = __DIR__ . "/../../../storage/documents/image_href/image_href_{$image->id}.html";
        $document = file_get_contents($path);
        var_dump($image->href);
        $xpath = $this->domService->createXpath($document);
        $src = $xpath->query('//div[contains(@class, "_current")]/img')->item(0)->getAttribute('src');
        $image->src = $src;
        $image->saveOrFail();
    }
}