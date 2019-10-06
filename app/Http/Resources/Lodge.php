<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Services\Text\Service;
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
        /** @var Service $generateService */
        $generateService = app(Service::class);
        $title = $generateService->title($this->resource, $siteId, (bool)$request->json('title_enable_station'));
        return [
            'id' => $lodge->id,
            'organization_name' => $lodge->organization->name,
            'title' => $title,
            'announce' => $lodge->announce,
            'stations' => new MetroStationCollection($lodge->stations),
            'description' => $lodge->description,
            'phone' => $lodge->getPhone(),
            'latitude' => $lodge->latitude,
            'longitude' => $lodge->longitude,
            'address' => $lodge->address,
            'opening_hours' => $lodge->opening_hours,
            'images' => new ImageCollection($lodge->images),
            'image_main' => new Image($lodge->imageMain)
        ];
    }

}
