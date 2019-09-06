<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Meta extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var $meta \App\Models\Meta */
        $meta = $this;
        return [
            'description' => $meta->description,
            'title' => $meta->title,
            'h1' => $meta->h1,
        ];
    }
}
