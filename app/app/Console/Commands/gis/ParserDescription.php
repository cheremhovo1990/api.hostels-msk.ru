<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 14.10.18
 * Time: 12:58
 */
declare(strict_types=1);


namespace App\Console\Commands\gis;


use App\Models\Pagination\Detail\Description;
use App\Models\Pagination\Detail\Detail;
use App\Services\DomService;
use Illuminate\Console\Command;

class ParserDescription extends Command
{
    protected $signature = 'parser:description';
    /**
     * @var DomService
     */
    private $domService;

    public function __construct(
        DomService $domService
    )
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
            if (!is_null($detail->description_href)) {
                $this->saveDescription($detail);
            }
        }

    }

    public function saveDescription(Detail $detail)
    {
        echo $detail->description_href . PHP_EOL;
        $document = file_get_contents(__DIR__ . "/../../../storage/documents/description/description_{$detail->id}.html");
        $xpath = $this->domService->createXpath($document);
        $descriptionNode = $xpath->query('//div[@class="articleCard__content"]/p[@class="articleCard__paragraph"]');

        for ($i = 0; $i < $descriptionNode->length; $i++) {
            $description = $descriptionNode->item($i)->textContent;
            $descriptionRecord = Description::create([
                'detail_id' => $detail->id,
                'description' => $description,
                'position' => $i,
            ]);
        }
    }
}