<?php 

class HostelCest
{
    public function pagination(AcceptanceTester $I)
    {
        for ($i = 1 ; $i <= 68; $i++) {
            $I->amOnPage("/moscow/search/хостолы/page/$i?queryState=center%2F37.724648%2C55.748951%2Fzoom%2F11");
            $documnt = $I->grabPageSource();
            file_put_contents(__DIR__ . "/../../storage/documents/pagination/pagination_$i.html", $documnt);
        }
    }
}
