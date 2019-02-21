<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Services\GenerateText\GenerateText;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class Lodge
 * @package App\Http\Resources
 */
class Lodge extends JsonResource
{
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
        $siteId = 1;
        $generateText = new GenerateText($lodge->resource, $siteId);
        $organization_name = $lodge->organization->name;
        $stations = $lodge->stations;
        $station = $stations->first();

        if (!is_null($station) && $request->json('title_enable_station')) {
            $title = $generateText->getTitleWithStation();
        } else {
            $title = $generateText->getTitle();
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

}
