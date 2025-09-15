<?php

namespace Modules\Search\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->resource instanceof \Modules\Auth\Entities\User) {
            return [
                'id'    => $this->id,
                'type'  => 'doctor',
                'name'  => $this->name,
                'image' => $this->image_path ?? null,
            ];
        }

        if ($this->resource instanceof \Modules\Product\Entities\Product) {
            return [
                'id'          => $this->id,
                'type'        => 'product',
                'name'        => $this->name,
                'description' => $this->description,
                'price'       => $this->price,
                'image'       => $this->image_path ?? null,
            ];
        }

        if ($this->resource instanceof \Modules\Product\Entities\Work) {
            return [
                'id'          => $this->id,
                'type'        => 'work',
                'title'       => $this->title,
                'description' => $this->description,
                'price'       => $this->price,
                'image'       => $this->image_path ?? null,
                'technician'  => $this->technician ? [
                    'id'   => $this->technician->id,
                    'name' => $this->technician->name,
                ] : null,
            ];
        }

        return parent::toArray($request);
    }
}
