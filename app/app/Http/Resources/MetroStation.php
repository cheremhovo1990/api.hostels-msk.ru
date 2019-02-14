<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class MetroStation
 * @package App\Http\Resources
 */
class MetroStation extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'hex_color' => $this->hex_color,
            'line_name' => $this->line_name,
        ];
    }
}
