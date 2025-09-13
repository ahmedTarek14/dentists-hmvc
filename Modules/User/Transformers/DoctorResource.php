<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'id'        => (int) $this->id,
            'type'      => (string) $this->type,
            'name'      => (string) $this->name,
            'email'     => (string) $this->email,
            'address' => (string)$this->address ? $this->address : null,
            'image' => $this->image ? $this->image_path : null,
            'city'      => $this->city ? [
                'id'   => (int) $this->city->id,
                'name' => (string) $this->city->name,
            ] : null,
            'district'  => $this->district ? [
                'id'   => (int) $this->district->id,
                'name' => (string) $this->district->name,
            ] : null,
            'average_rating' => $this->averageRating() ? round($this->averageRating(), 1) : null,
        ];
    }
}
