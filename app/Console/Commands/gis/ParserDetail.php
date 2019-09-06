<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 07.10.18
 * Time: 14:15
 */
declare(strict_types=1);


namespace App\Console\Commands\gis;


use App\Models\Pagination\Detail\Attribute;
use App\Models\Pagination\Detail\Detail;
use App\Models\Pagination\Detail\Phone;
use App\Models\Pagination\Pagination;
use App\Services\DomService;
use Illuminate\Console\Command;

class ParserDetail extends Command
{
    protected $signature = 'parser:detail';
    /**
     * @var DomService
     */
    private $domService;

    /**
     * ParserDetail constructor.
     * @param DomService $domService
     */
    public function __construct(DomService $domService)
    {
        parent::__construct();
        $this->domService = $domService;
    }


    public function handle()
    {
        $paginations = Pagination::where('parsed', 1)->get();
        foreach ($paginations as $pagination) {
            $this->detail($pagination);
            $pagination->notParsed();
            $pagination->save();
        }
    }

    public function detail(Pagination $pagination)
    {
        echo $pagination->href . PHP_EOL;
        $document = file_get_contents(__DIR__ . "/../../../storage/documents/detail/detail_{$pagination->id}.html");
        $xpath = $this->domService->createXpath($document);
        $name = $xpath->query('//h1[@class="cardHeader__headerNameText"]')->item(0)->textContent;
        $title = $this->getTitle($xpath);
        $rating = $this->getRating($xpath);
        $descriptionHref = $this->getDescriptionHref($xpath);
        $text = $this->getText($xpath);
        $brandImgHref = $this->getBrandImgHref($xpath);
        $latitude = $xpath->query('//address[@class="card__address"]')->item(0)->getAttribute('data-lat');
        $longitude = $xpath->query('//address[@class="card__address"]')->item(0)->getAttribute('data-lon');
        $address = $xpath->query('//a[@class="card__addressLink _undashed"]')->item(0)->textContent;
        $branchHref = $this->getBranchHref($xpath);
        $workHouse = $this->getWorkHouse($xpath);
        $imgHref = $this->getImgHref($xpath);
        $site = $this->getSite($xpath);
        $email = $this->getEmail($xpath);
        $commentHref = $this->getCommentHref($xpath);
        $detail = Detail::create([
            'pagination_id' => $pagination->id,
            'name' => $name,
            'title' => $title,
            'rating' => $rating,
            'description_href' => $descriptionHref,
            'text' => $text,
            'brand_img_href' => $brandImgHref,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'address' => $address,
            'branch_href' => $branchHref,
            'work_hour' => $workHouse,
            'img_href' => $imgHref,
            'site' => $site,
            'email' => $email,
            'comment_href' => $commentHref,
        ]);

        $this->phones($xpath, $detail);
        $this->attribute($xpath, $detail);
    }

    public function getRating(\DOMXPath $xpath): ?int
    {
        $ratingNode = $xpath->query('//div[contains(@class, "customRating__stars _value")]')->item(0);
        if (is_null($ratingNode)) {
            return null;
        }
        preg_match('~customRating__stars _value_(\d{1,3})~', $ratingNode->getAttribute('class'), $match);
        $ratingValue = $match[1];
        return (int)$ratingValue;
    }

    private function getBrandImgHref(\DOMXPath $xpath): ?string
    {
        $imgNode = $xpath->query('//img[@class="cardHeader__headerLogoImg"]')->item(0);
        if (is_null($imgNode)) {
            return null;
        }
        return $imgNode->getAttribute('src');
    }

    private function getBranchHref(\DOMXPath $xpath): ?string
    {
        $branchNode = $xpath->query('//a[@class="link card__filialsLink undashed"]')->item(0);
        if (is_null($branchNode)) {
            return null;
        }
        return $branchNode->getAttribute('href');
    }

    private function phones(\DOMXPath $xpath, Detail $detail)
    {
        $list = $xpath->query('//div[@class="contact__phonesItem _type_phone"]/a');
        for ($i = 0; $i < $list->length; $i++) {
            $phone = str_replace('tel:+', '', $list->item($i)->getAttribute('href'));
            Phone::create([
                'detail_id' => $detail->id,
                'phone' => $phone,
            ]);
        }
    }

    private function attribute(\DOMXPath $xpath, Detail $detail)
    {
        $list = $xpath->query('//div[@class="cardAttributes__attrs _full"]//li');
        for ($i = 0; $i < $list->length; $i++) {
            $label = $xpath->query('.//div[@class="cardAttributes__attrsListLabel"]', $list->item($i))->item(0);
            $attribute = $xpath->query('.//span[@class="cardAttributes__attrsItem"]', $list->item($i))->item(0)->textContent;

            if (!is_null($label)) {
                $attribute = "{$label->textContent} $attribute";
            }
            Attribute::create([
                'detail_id' => $detail->id,
                'attribute' => $attribute,
            ]);
        }
    }


    /**
     * @param \DOMXPath $xpath
     * @return null|string
     */
    private function getSite(\DOMXPath $xpath): ?string
    {
        $siteNode = $xpath->query('//div[@class="contact__link _type_website"]')->item(0);
        if (is_null($siteNode)) {
            return null;
        }
        return $siteNode->textContent;
    }

    private function getCommentHref(\DOMXPath $xpath): ?string
    {
        $commentHrefNode = $xpath->query('//section[@class="reviewPreview"]/a')->item(0);
        if (is_null($commentHrefNode)) {
            return null;
        }
        return $commentHrefNode->getAttribute('href');
    }


    private function getTitle(\DOMXPath $xpath): ?string
    {
        $title = $xpath->query('//div[@class="cardHeader__headerDescriptionText"]')->item(0);
        if (is_null($title)) {
            return null;
        }
        return $title->textContent;
    }

    private function getImgHref(\DOMXPath $xpath): ?string
    {
        $imgHref = $xpath->query('//a[@class="cardPhotos__photos"]')->item(0);
        if (is_null($imgHref)) {
            return null;
        }
        return $imgHref->getAttribute('href');
    }

    private function getDescriptionHref(\DOMXPath $xpath): ?string
    {
        $descriptionHref = $xpath->query('//a[@class="cardHeader__cuteWrapper"]')->item(0);
        if (is_null($descriptionHref)) {
            return null;
        }
        return $descriptionHref->getAttribute('href');
    }

    private function getText(\DOMXPath $xpath): ?string
    {
        $text = $xpath->query('//a[@class="cardHeader__cuteWrapper"]')->item(0);
        if (is_null($text)) {
            return null;
        }
        return $text->textContent;
    }

    private function getWorkHouse(\DOMXPath $xpath): ?string
    {
        $workHouse = $xpath->query('//div[@class="microSchedule__title"]')->item(0);
        if (is_null($workHouse)) {
            return null;
        }
        return $workHouse->textContent;
    }

    private function getEmail(\DOMXPath $xpath)
    {
        $email = $xpath->query('//div[@class="contact__link _type_email"]/a')->item(0);
        if (is_null($email)) {
            return null;
        }
        return $email->textContent;
    }
}