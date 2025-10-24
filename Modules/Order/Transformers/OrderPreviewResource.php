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
            'price'             => (float)  $this->product_price,                // سعر المنتج أو الخدمة
            'shipping_fees'     => (float)  $this->shipping_fees,                // رسوم الشحن
            'total_price'       => (float)  $this->total_price,                  // المجموع الكلي
            'service_number'    => (string) $this->service_number,               // رقم الخدمة الفريد

            'requester_id'      => (int)    $this->requester_id,                 // ID العميل
            'provider_id'       => $this->provider_id ? (int) $this->provider_id : null,    // ID مقدم الخدمة

            'city_from_id'      => $this->city_from_id ? (int) $this->city_from_id : null,          // مدينة الشحن (من)
            'district_from_id'  => $this->district_from_id ? (int) $this->district_from_id : null,  // حي الشحن (من)

            'city_to_id'        => (int)    $this->city_to_id,                   // مدينة الوجهة (إلى)
            'district_to_id'    => (int)    $this->district_to_id,               // حي الوجهة (إلى)

            'product_id'        => $this->product_id ? (int) $this->product_id : null, // المنتج
            'work_id'           => $this->work_id ? (int) $this->work_id : null,       // الخدمة

            'address'           => (string) $this->address ?? '',                 // عنوان العميل
            'more_info'         => (string) $this?->more_info,
        ];
    }
}
