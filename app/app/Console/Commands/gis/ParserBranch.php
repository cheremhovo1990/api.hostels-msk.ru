<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 23.10.18
 * Time: 7:23
 */
declare(strict_types=1);


namespace App\Console\Commands\gis;


use App\Models\Pagination\Detail\Detail;
use App\Services\DomService;
use Illuminate\Console\Command;

class ParserBranch extends Command
{
    protected $signature = 'parser:branch';
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
         * @var Detail[] $details
         */
        $details = Detail::whereNotNull('branch_href')->get();
        foreach ($details as $detail) {
            echo $detail->branch_href . PHP_EOL;
            $document = file_get_contents(__DIR__ . "/../../../storage/documents/branch/branch_{$detail->id}.html");
            $xpath = $this->domService->createXpath($document);
            $numberBranch = $xpath->query('//div[@class="searchResults__additionalFilials"]')->item(0)->textContent;
            $detail->number_branch = $numberBranch;
            $detail->saveOrFail();
        }
    }
}