<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'              => (int) $this->id,
            'title'           => (string) $this->title,
            'description'     => (string) $this?->description,
            'price'           => (float) $this->price,
            'image'           => $this->image ? $this->image_path : null,
            'technician'      => [
                'id'   => (int) $this->technician?->id,
                'name' =>  $this->technician?->name,
                'phone' => (string) $this->technician?->phone,
                'type_name' => (string) $this->technician?->typeRelation?->name,
            ],
            'rating' => round((float) ($this->ratings_avg_rating ?? 0), 1), // من withAvg
        ];
    }
}
