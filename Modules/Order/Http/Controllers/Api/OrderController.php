<?php

namespace Modules\Order\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Modules\City\Entities\City;
use Modules\Order\Entities\Order;
use Modules\Order\Http\Requests\Api\ConfirmOrderRequest;
use Modules\Order\Http\Requests\Api\OrderRequest;
use Modules\Order\Transformers\OrderpreviewResource;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Work;

class OrderController extends Controller
{
    public function preview(OrderRequest $request)
    {
        try {

            $requester_id = sanctum()->id();
            if (!$request->product_id && !$request->work_id) {
                return api_response_error('You must provide either a product_id or work_id');
            }

            $price = $request->product_id
                ? Product::find($request->product_id)->price
                : Work::find($request->work_id)->price;

            $shipping = City::find($request->city_to_id)->shipping_fees ?? 0;
            $total = $price + $shipping;

            // توليد رقم خدمة فريد
            $lastOrderId = Order::max('id') + 1;
            $serviceNumber = 'SRV' . str_pad($lastOrderId, 6, '0', STR_PAD_LEFT);

            // تأكد إنه مش موجود (احتياطي)
            while (Order::where('service_number', $serviceNumber)->exists()) {
                $lastOrderId++;
                $serviceNumber = 'SRV' . str_pad($lastOrderId, 6, '0', STR_PAD_LEFT);
            }

            $order = new Order([
                'product_price' => $price,
                'shipping_fees' => $shipping,
                'total_price' => $total,
                'service_number' => $serviceNumber,
                'requester_id' => $requester_id,
                'provider_id' => $request->provider_id,
                'city_from_id' => sanctum()->user()->city->id, //المفروض اجيبها من اليوزر 
                'city_to_id' => $request->city_to_id,
                'product_id' => $request->product_id,
                'work_id' => $request->work_id,
            ]);

            $data = new OrderPreviewResource($order);

            return api_response_success($data);
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return api_response_error();
        }
    }

    // تأكيد الطلب وإنشاؤه في قاعدة البيانات
    public function confirm(ConfirmOrderRequest $request)
    {
        try {
            $order = Order::create([
                'service_number' => $request->service_number,
                'product_id'     => $request?->product_id,
                'work_id'        => $request?->work_id,
                'requester_id'   => $request->requester_id,
                'provider_id'    => $request?->provider_id,
                'city_from_id'   => $request->city_from_id,
                'city_to_id'     => $request->city_to_id,
                'product_price'  => $request->product_price,
                'shipping_fees'  => $request->shipping_fees,
                'total_price'    => $request->total_price,
                'status'         => 'pending',
            ]);

            return response()->json([
                'message' => 'Order created successfully.',
                'order'   => $order,
            ], 200);
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return api_response_error();
        }
    }
}
