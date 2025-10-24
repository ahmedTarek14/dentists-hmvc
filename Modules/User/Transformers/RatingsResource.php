<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingsResource extends JsonResource
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
            'id'              => $this->id,
            'rating'          => (float) $this->rating,
            'comment'         => $this->comment,
            'created_at'      => $this->created_at ? $this->created_at->format('Y-m-d H:i') : null,
        ];
    }
}
