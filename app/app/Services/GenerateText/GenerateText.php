<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 21.02.19
 * Time: 10:46
 */
declare(strict_types=1);


namespace App\Services\GenerateText;


use App\Models\MetroStation;
use App\Models\Organization\Lodge;
use App\Models\Organization\Organization;
use App\Services\GenerateText\MetroStation as GenerateMetroStation;

/**
 * Class GenerateText
 * @package App\Services\GenerateText
 */
class GenerateText
{
    /**
     * @var Lodge
     */
    private $lodge;


    /**
     * @var int
     */
    private $siteId;

    /**
     * GenerateText constructor.
     * @param Lodge $lodge
     * @param int $siteId
     */
    public function __construct(
        Lodge $lodge,
        int $siteId
    )
    {
        $this->lodge = $lodge;
        $this->siteId = $siteId;
    }


    /**
     * @return string
     */
    public function getTitle(): string
    {
        return (new Title($this))->generate();
    }

    /**
     * @return string
     */
    public function getTitleWithStation(): string
    {
        $title = $this->getTitle();
        $metro = (new GenerateMetroStation($this))->generateForTitle();
        return "$title {$metro}";
    }

    /**
     * @return string
     */
    public function getMetro(): string
    {
        return (new GenerateMetroStation($this))->getMetro();
    }

    /**
     * @return int
     */
    public function getIdentity(): int
    {
        return $this->siteId + $this->lodge->id;
    }


    /**
     * @return Organization
     */
    public function getOrganization(): Organization
    {
        return $this->lodge->organization;
    }

    /**
     * @return MetroStation
     */
    public function getMetroStation(): MetroStation
    {
        return $this->lodge->stations->first();
    }

    public function getMetroStations()
    {
        return $this->lodge->stations;
    }
}