<?php

namespace App\Http\Resources;

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
        $organization = $lodge->organization;
        $organization_name = $organization->name;

        return [
            'id' => $lodge->id,
            'organization_name' => $organization_name,
            'announce' => $lodge->announce,
            'phone' => $lodge->getPhone(),
            'latitude' => $lodge->latitude,
            'longitude' => $lodge->longitude,
        ];
    }
}
