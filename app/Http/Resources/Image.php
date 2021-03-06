<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Image extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Image $image */
        $image = $this;
        return [
            'id' => $image->id,
            'uri' => $image->src,
            'host' => config('app.url'),
        ];
    }
}
