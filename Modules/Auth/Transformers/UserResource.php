<?php

namespace Modules\Auth\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'type' => (string)$this->type,
            'name' => (string)$this->name,
            'email' => (string)$this->email,
            'phone' => $this->phone ? (string) $this->phone : null,
            'address' => (string)$this->address ? $this->address : null,
            'image' => $this->image ? $this->image_path : null,
            'type_id' => $this->type_id ? (int) $this->type_id : null,
            'type_name' => $this->type_id ? (string) $this->typeRelation->name : null,
            'city_id' => $this->city_id ? (int) $this->city_id : null,
            'city_name' => $this->city_id ? (string) $this->city->name : null,
            'district_id' => $this->district_id ? (int) $this->district_id : null,
            'district_name' => $this->district_id ? (string) $this->district->name : null,
        ];
    }
}
