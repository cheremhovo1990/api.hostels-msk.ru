<?php

use App\Models\Pagination\Detail\Detail;
use App\Models\Pagination\Detail\Image;
use App\Models\Pagination\Pagination;

class HostelCest
{
    public function branches(AcceptanceTester $I)
    {
        $details = Detail::whereNotNull('branch_href')->get();
        foreach ($details as $detail) {
            $this->branch($I, $detail);
        }
    }

    protected function branch(AcceptanceTester $I, Detail $detail)
    {
        $path = __DIR__ . "/../../storage/documents/branch/branch_{$detail->id}.html";
        $I->amOnPage($detail->branch_href);
        $I->wait(2);
        $document = $I->grabPageSource();
        file_put_contents($path, $document);
    }


    protected function reviews(AcceptanceTester $I)
    {
        $details = Detail::whereNotNull('comment_href')->get();
        foreach ($details as $detail) {
            $this->review($I, $detail);
        }
    }

    protected function review(AcceptanceTester $I, Detail $detail)
    {
        $path = __DIR__ . "/../../storage/documents/review/review_{$detail->id}.html";
        $I->amOnPage($detail->comment_href);
        $I->wait(2);
        $document = $I->grabPageSource();
        file_put_contents($path, $document);
    }


    protected function imageSources(AcceptanceTester $I)
    {
        /*        $images = Image::all();
                foreach ($images as $image) {
                    $this->imageSource($I, $image);
                }*/
        $this->imageSource($I, Image::find(6404));
    }

    protected function imageSource(AcceptanceTester $I, Image $image)
    {
        $path = __DIR__ . "/../../storage/documents/image_href/image_href_{$image->id}.html";
        //if (!file_exists($path)) {
        $I->amOnPage($image->href);
        $I->wait(1);
        $document = $I->grabPageSource();
        file_put_contents($path, $document);
        //}
    }

    protected function images(AcceptanceTester $I)
    {
        /** @var Detail[] $details */
        $details = Detail::where('parsed', 0)->get();
        /*        foreach ($details as $detail) {
                    if (!is_null($detail->img_href)) {
                        $this->image($I, $detail);
                    }
                }*/

        $this->image($I, Detail::find(195));
    }

    protected function image(AcceptanceTester $I, Detail $detail)
    {
        $I->amOnPage($detail->img_href);
        $I->wait(1);
        $I->moveMouseOver(null, 100);
        $I->wait(1);
        $I->makeScreenshot('image');
        //$document = $I->grabPageSource();
        //file_put_contents(__DIR__ . "/../../storage/documents/image/image_{$detail->id}.html", $document);
    }

    protected function descriptions(AcceptanceTester $I)
    {
        /** @var Detail[] $details */
        $details = Detail::where('parsed', 0)->get();
        foreach ($details as $detail) {
            if (!is_null($detail->description_href)) {
                $this->description($I, $detail);
            }

        }
    }

    protected function description(AcceptanceTester $I, Detail $detail)
    {
        $I->amOnPage($detail->description_href);
        $document = $I->grabPageSource();
        file_put_contents(__DIR__ . "/../../storage/documents/description/description_{$detail->id}.html", $document);
    }

    private function details(AcceptanceTester $I)
    {
        $paginations = Pagination::all();
        foreach ($paginations as $pagination) {
            $this->detail($I, $pagination);
        }

    }

    private function detail(AcceptanceTester $I, Pagination $pagination)
    {
        $I->amOnPage($pagination->href);
        $documnt = $I->grabPageSource();
        file_put_contents(__DIR__ . "/../../storage/documents/detail/detail_{$pagination->id}.html", $documnt);
    }

    private function pagination(AcceptanceTester $I)
    {
        for ($i = 1 ; $i <= 68; $i++) {
            $I->amOnPage("/moscow/search/хостолы/page/$i?queryState=center%2F37.724648%2C55.748951%2Fzoom%2F11");
            $documnt = $I->grabPageSource();
            file_put_contents(__DIR__ . "/../../storage/documents/pagination/pagination_$i.html", $documnt);
        }
    }
}
