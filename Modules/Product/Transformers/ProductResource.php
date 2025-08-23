<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id' => (int)$this->id,
            'name' => (string)$this->name,
            'description' => $this->description ? (string) $this->description : null,
            'price' => (float) $this->price,
            'image' => $this->image ? $this->image_path : null,
            'rating' => round((float) ($this->ratings_avg_rating ?? 0), 1),
        ];
    }
}
