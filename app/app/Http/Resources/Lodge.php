<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class Lodge
 * @package App\Http\Resources
 */
class Lodge extends JsonResource
{
    /**
     * @var array
     */
    public $lodges = [
        'хостел',
        'hostel',
        'мини хостел',
        'мини-отель',
        'общежитие',
    ];

    /**
     * @var array
     */
    public $metro = [
        'м.',
        'метро'
    ];

    /**
     * @var array
     */
    public $nearMetro = [
        'рядом c',
        'около',
        'возле',
    ];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Organization\Lodge $lodge */
        $lodge = $this;
        $organization = $lodge->organization;
        $organization_name = $organization->name;
        $siteId = 1;
        $stations = $lodge->stations;
        $station = $stations->first();
        $stationName = is_null($station) ? null : $station->name;
        return [
            'id' => $lodge->id,
            'organization_name' => $organization_name,
            'title' => $this->getTitle($siteId, $lodge->id, $organization_name, $stationName),
            'announce' => $lodge->announce,
            'phone' => $lodge->getPhone(),
            'latitude' => $lodge->latitude,
            'longitude' => $lodge->longitude,
        ];
    }

    /**
     * @param int $siteId
     * @param int $lodgeId
     * @param string $organizationName
     * @param string|null $stationName
     * @return string
     */
    public function getTitle(int $siteId, int $lodgeId, string $organizationName, string $stationName = null)
    {
        $identity = $siteId + $lodgeId;
        $title = mb_convert_case($this->lodges[$identity % count($this->lodges)], MB_CASE_TITLE);
        if (is_null($stationName)) {
            return "$title \"{$organizationName}\"";
        }
        $metro = $this->metro[$identity % count($this->metro)];
        $nearMetro = $this->nearMetro[$identity % count($this->nearMetro)];
        return "$title \"{$organizationName}\" {$nearMetro} {$metro} {$stationName}";
    }
}
