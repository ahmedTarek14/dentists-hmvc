<?php

namespace Modules\Search\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
         public function toArray($request)
    {
        if ($this->resource instanceof \Modules\Auth\Entities\User) {
            return [
                'id'    => $this->id,
                'name'  => $this->name,
                'type'  => $this->type,
                'image' => $this->image_path ?? null,
                'works' => $this->when($this->type == 'technician', function () {
                    return $this->works->map(function ($work) {
                        return [
                            'id'    => $work->id,
                            'title' => $work->title,
                            'description' => $work->description,
                            'price' => $work->price,
                            'image' => $work->image_path ?? null,
                        ];
                    });
                }),
            ];
        }

        if ($this->resource instanceof \Modules\Product\Entities\Product) {
            return [
                'id'          => $this->id,
                'name'        => $this->name,
                'description' => $this->description,
                'price'       => $this->price,
                'image'       => $this->image_path ?? null,
            ];
        }

        if ($this->resource instanceof \Modules\Product\Entities\Work) {
            return [
                'id'          => $this->id,
                'title'       => $this->title,
                'description' => $this->description,
                'price'       => $this->price,
                'image'       => $this->image_path ?? null,
            ];
        }

        return parent::toArray($request);
    }
}