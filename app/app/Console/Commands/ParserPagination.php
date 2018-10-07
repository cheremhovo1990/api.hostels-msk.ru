<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Attribute;
use App\Pagination;
use App\Services\DomService;
use Illuminate\Console\Command;

/**
 * Class ParserPagination
 * @package App\Console\Commands
 */
class ParserPagination extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:pagination';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var DomService
     */
    private $domService;

    /**
     * Create a new command instance.
     *
     * @param DomService $domService
     */
    public function __construct(DomService $domService)
    {
        parent::__construct();
        $this->domService = $domService;
    }

    /**
     * Execute the console command.
     *
     * @param DomService $domService
     * @return mixed
     */
    public function handle()
    {
        $this->create(1);
    }

    public function create(int $i)
    {
        $document = file_get_contents(__DIR__."/../../../storage/documents/pagination/pagination_$i.html");
        $xpath = $this->domService->createXpath($document);
        $list = $xpath->query('//div[@class="searchResults__list"]/article[@data-module="miniCard"]');
        for ($i=0;$i < $list->length; $i++) {
            $href = $xpath->query('.//h3/a', $list->item($i))->item(0)->getAttribute('href');
            $title = $xpath->query('.//h3/a', $list->item($i))->item(0)->textContent;
            $adv = $xpath->query('.//div[@data-adv=" – реклама"]', $list->item($i))->item(0)->textContent;
            $address = $xpath->query('.//span[@class="miniCard__address"]', $list->item($i))->item(0)->textContent;
            $branchNode = $xpath->query('.//div[@class="miniCard__filialsWrapper"]/a', $list->item($i))->item(0);
            if (!is_null($branchNode)) {
                $branchHref = $branchNode->getAttribute('href');
            } else {
                $branchHref = null;
            }
            $ratingValue = $this->getRating($xpath, $list->item($i));

            $brandImgHref = $this->getImageBrand($xpath, $list->item($i));

            $pagination = Pagination::create([
                'href' => $href,
                'title' => $title,
                'adv' => $adv,
                'address' => $address,
                'branch_href' => $branchHref,
                'rating' => $ratingValue,
                'brand_img_href' => $brandImgHref,
            ]);

            $this->attribute($xpath, $list->item($i), $pagination);
        }
    }

    /**
     * @param \DOMXPath $xpath
     * @param \DOMElement $DOMElement
     * @return null|string
     */
    public function getImageBrand(\DOMXPath $xpath, \DOMElement $DOMElement): ?string
    {
        $imageNode = $xpath->query('.//img[@class="miniCard__photosPreviewImage"]', $DOMElement)->item(0);
        if (is_null($imageNode)) {
            return null;
        }
        return $imageNode->getAttribute('src');
    }

    /**
     * @param \DOMXPath $xpath
     * @param \DOMElement $DOMElement
     * @return int
     */
    public function getRating(\DOMXPath $xpath, \DOMElement $DOMElement): int
    {
        $ratingNode = $xpath->query('.//div[contains(@class, "miniCard__rating")]', $DOMElement)->item(0);
        if (is_null($ratingNode)) {
            return 0;
        }
        preg_match('~rating _value_(\d{1,3})~', $ratingNode->getAttribute('class'), $match);
        $ratingValue = $match[1];
        return (int)$ratingValue;
    }

    /**
     * @param \DOMXPath $xpath
     * @param \DOMElement $DOMElement
     * @param Pagination $pagination
     */
    public function attribute(\DOMXPath $xpath, \DOMElement $DOMElement, Pagination $pagination): void
    {
        $list = $xpath->query('//ul[@class="miniCard__attrs"]/li', $DOMElement);
        for ($i=0;$i < $list->length; $i++) {
            $attribute = $list->item($i)->textContent;
            $attributeRecord = Attribute::create([
                'pagination_id' => $pagination->id,
                'attribute' => $attribute,
            ]);
        }
    }
}
