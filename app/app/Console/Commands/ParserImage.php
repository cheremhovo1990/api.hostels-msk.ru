<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 14.10.18
 * Time: 15:55
 */
declare(strict_types=1);


namespace App\Console\Commands;


use App\Models\Pagination\Detail\Detail;
use App\Models\Pagination\Detail\Image;
use App\Services\DomService;
use Illuminate\Console\Command;

class ParserImage extends Command
{
    protected $signature = 'parser:image';
    /**
     * @var DomService
     */
    private $domService;


    /**
     * ParserImage constructor.
     * @param DomService $domService
     */
    public function __construct(DomService $domService)
    {
        parent::__construct();
        $this->domService = $domService;
    }


    public function handle()
    {
        /**
         * @var $details Detail[]
         */
        $details = Detail::where('parsed', 0)->get();
        foreach ($details as $detail) {
            if (!is_null($detail->img_href)) {
                $this->image($detail);
            }
        }
    }

    public function image(Detail $detail)
    {
        echo $detail->img_href . PHP_EOL;
        $document = file_get_contents(__DIR__ . "/../../../storage/documents/image/image_{$detail->id}.html");
        $xpath = $this->domService->createXpath($document);
        $imageNode = $xpath->query('//div[@class="patchwork__wrap"]//a[@class="patchwork__itemLink"]');
        for ($i = 0; $i < $imageNode->length; $i++) {
            $imageHref = $imageNode->item($i)->getAttribute('href');
            Image::create([
                'detail_id' => $detail->id,
                'href' => $imageHref,
            ]);
        }
    }
}