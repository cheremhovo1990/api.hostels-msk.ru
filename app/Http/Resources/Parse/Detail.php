<?php

namespace App\Http\Resources\Parse;

use Illuminate\Http\Resources\Json\JsonResource;

class Detail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'url' => route('cp.details.create', $this),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
