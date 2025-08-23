<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderPreviewResource extends JsonResource
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
            'price'          => (float)  $this->product_price,            // سعر المنتج أو الخدمة
            'shipping_fees'  => (float)  $this->shipping_fees,    // رسوم الشحن
            'total_price'    => (float)  $this->total_price,      // المجموع الكلي
            'service_number' => (string) $this->service_number,   // رقم الخدمة الفريد
            'requester_id'   => (int)    $this->requester_id,     // ID الدكتور
            'provider_id'    =>  $this->provider_id ? (int) $this->provider_id : null,      // ID الفني
            'city_from_id'   =>  $this->city_from_id ? (int) $this->city_from_id : null,     // ID مدينة الشحن
            'city_to_id'     => (int)    $this->city_to_id,       // ID المدينة المستقبلة
            'product_id'     => $this->product_id ? (int) $this->product_id : null, // ID المنتج (nullable)
            'work_id'        => $this->work_id ? (int) $this->work_id : null,       // ID الخدمة (nullable)
        ];
    }
}
