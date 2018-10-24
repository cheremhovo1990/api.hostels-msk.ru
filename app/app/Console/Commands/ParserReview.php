<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 16.10.18
 * Time: 7:38
 */
declare(strict_types=1);


namespace App\Console\Commands;


use App\Models\Pagination\Detail\Detail;
use App\Models\Pagination\Detail\Review;
use App\Services\DomService;
use Illuminate\Console\Command;

class ParserReview extends Command
{
    protected $signature = 'parser:review';

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
        \DB::transaction(function () {
            $details = Detail::whereNotNull('comment_href')->where('parsed', 0)->get();

            foreach ($details as $detail) {
                $this->review($detail);
            }
        });
    }

    private function review(Detail $detail)
    {
        $path = __DIR__ . "/../../../storage/documents/review/review_{$detail->id}.html";
        $document = file_get_contents($path);
        var_dump($detail->comment_href);
        $xpath = $this->domService->createXpath($document);
        $totalRating = $this->getTotalRating($xpath);
        $amount = $this->getAmount($xpath);
        $detail->number_review = $amount;
        $detail->saveOrFail();
        $this->reviews($xpath, $detail);
    }

    public function getTotalRating(\DOMXPath $xpath): ?int
    {
        $ratingRaw = $xpath->query('//div[@class="reviewsForm__header"]//div[contains(@class, "stars__stars _value_")]')->item(0);
        if (is_null($ratingRaw)) {
            return null;
        }
        preg_match('~stars__stars _value_(\d{1,3})~', $ratingRaw->getAttribute('class'), $match);
        $ratingValue = $match[1];
        return (int)$ratingValue;
    }

    public function getAmount(\DOMXPath $xpath)
    {
        $amount = $xpath->query('//div[@class="reviewsForm__header"]//div[@class="reviewsForm__amount"]')->item(0)->textContent;
        return $amount;
    }

    private function reviews(\DOMXPath $xpath, Detail $detail)
    {
        $reviewList = $xpath->query('//div[@class="scroller__inner"]//div[@class="reviewsForm__review"]');

        for ($i = 0; $i < $reviewList->length; $i++) {
            $reviewNode = $reviewList->item($i);
            $name = $xpath->query('.//div[@class="review__userName"]', $reviewNode)->item(0)->textContent;
            $text = $xpath->query('.//div[contains(@class, "review__content")]', $reviewNode)->item(0)->textContent;
            $rating = $this->getRatingReview($xpath, $reviewNode);
            $date = $xpath->query('.//span[@class="review__date"]', $reviewNode)->item(0)->textContent;
            $completeNode = $xpath->query('.//span[@class="link _undashed"]', $reviewNode)->item(0);
            if (is_null($completeNode)) {
                $isComplete = 1;
            } else {
                $isComplete = 0;
            }
            Review::create([
                'detail_id' => $detail->id,
                'name' => $name,
                'text' => $text,
                'rating' => $rating,
                'date' => $date,
                'complete' => $isComplete,
            ]);
        }
    }

    private function getRatingReview(\DOMXPath $xpath, \DOMElement $reviewNode): ?int
    {
        $ratingRaw = $xpath->query('.//div[contains(@class, "stars__stars _value_")]', $reviewNode)->item(0);
        if (is_null($ratingRaw)) {
            return null;
        }
        preg_match('~stars__stars _value_(\d{1,3})~', $ratingRaw->getAttribute('class'), $match);
        $ratingValue = $match[1];
        return (int)$ratingValue;
    }
}