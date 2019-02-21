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
        'общежития эконом-класса',
        'общежитие гостиничного типа'
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
        $identity = $siteId + $lodge->id;

        if (!is_null($station) && $request->json('title_enable_station')) {
            $title = $this->getTitleWithStation($identity, $organization_name, $station->name);
        } else {
            $title = $this->getTitle($identity, $organization_name);
        }
        return [
            'id' => $lodge->id,
            'organization_name' => $organization_name,
            'title' => $title,
            'announce' => $lodge->announce,
            'stations' => new MetroStationCollection($stations),
            'description' => $lodge->description,
            'phone' => $lodge->getPhone(),
            'latitude' => $lodge->latitude,
            'longitude' => $lodge->longitude,
            'address' => $lodge->address,
        ];
    }

    /**
     * @param int $identity
     * @param string $organizationName
     * @return string
     */
    public function getTitle(int $identity, string $organizationName)
    {
        $title = mb_convert_case($this->lodges[$identity % count($this->lodges)], MB_CASE_TITLE);
        return "$title \"{$organizationName}\"";
    }

    /**
     * @param int $identity
     * @param string $organizationName
     * @param string|null $stationName
     * @return string
     */
    public function getTitleWithStation(int $identity, string $organizationName, string $stationName)
    {
        $title = $this->getTitle($identity, $organizationName);
        $metro = $this->metro[$identity % count($this->metro)];
        $nearMetro = $this->nearMetro[$identity % count($this->nearMetro)];
        return "$title {$nearMetro} {$metro} {$stationName}";
    }
}
