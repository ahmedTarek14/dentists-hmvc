<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'             => $this->id,
            'service_number' => $this->service_number,
            'status'         => $this->status,
            'total_price'    => $this->total_price,
            'product_price'  => $this->product_price,
            'shipping_fees'  => $this->shipping_fees,

            'product' => $this->product ? [
                'id'    => $this->product->id,
                'name'  => $this->product->name ?? null,
            ] : null,

            'work' => $this->work ? [
                'id'    => $this->work->id,
                'title' => $this->work->title ?? null,
            ] : null,

            'requester' => $this->requester ? [
                'id'    => $this->requester->id,
                'name'  => $this->requester->name,
                'type'  => $this->requester->type,
            ] : null,

            'provider' => $this->provider ? [
                'id'    => $this->provider->id,
                'name'  => $this->provider->name,
                'type'  => $this->provider->type,
            ] : null,

            'city_from' => $this->city_from ? $this->city_from->name : null,
            'city_to'   => $this->city_to ? $this->city_to->name : null,

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
