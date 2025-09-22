<?php

namespace Modules\Order\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Modules\Auth\Entities\User;
use Modules\City\Entities\City;
use Modules\City\Entities\District;
use Modules\Order\Entities\Order;
use Modules\Order\Http\Requests\Api\ConfirmOrderRequest;
use Modules\Order\Http\Requests\Api\OrderRequest;
use Modules\Order\Transformers\OrderPreviewResource;
use Modules\Order\Transformers\OrderResource;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Work;

class OrderController extends Controller
{
    public function preview(OrderRequest $request)
    {
        try {

            $requesterId = sanctum()->id();
            $price = $request->product_id
                ? Product::findOrFail($request->product_id)->price
                : Work::findOrFail($request->work_id)->price;

            $shipping = District::find($request->district_to_id)->shipping_fees ?? 0;
            $total = $price + $shipping;

            $cityFromId = null;
            $districtFromId = null;

            if ($request->work_id) {
                $provider = User::findOrFail($request->provider_id);
                $cityFromId = $provider->city_id ?? null;
                $districtFromId = $provider->district_id ?? null;
            }

            $serviceNumber = $this->generateServiceNumber();
            $order = new Order([
                'product_price'     => $price,
                'shipping_fees'     => $shipping,
                'total_price'       => $total,
                'service_number'    => $serviceNumber,
                'requester_id'      => $requesterId,
                'provider_id'       => $request->provider_id,
                'city_from_id'      => $cityFromId,
                'district_from_id'  => $districtFromId,
                'city_to_id'        => $request->city_to_id,
                'district_to_id'    => $request->district_to_id,
                'product_id'        => $request->product_id,
                'work_id'           => $request->work_id,
                'address'           => $request->address,
                'more_info'           => $request->more_info,
            ]);

            return api_response_success(new OrderPreviewResource($order));
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }

    public function confirm(ConfirmOrderRequest $request)
    {
        try {
            $order = Order::create([
                'service_number' => $request->service_number,
                'product_id'     => $request?->product_id,
                'work_id'        => $request?->work_id,
                'requester_id'   => $request->requester_id,
                'provider_id'    => $request?->provider_id,
                'city_from_id'   => $request?->city_from_id,
                'city_to_id'     => $request->city_to_id,
                'district_from_id'   => $request?->district_from_id,
                'district_to_id'    => $request->district_to_id,
                'product_price'  => $request->product_price,
                'shipping_fees'  => $request->shipping_fees,
                'total_price'    => $request->total_price,
                'status'         => 'pending',
                'address'           => $request->address,
                'more_info'           => $request->more_info,
            ]);

            return response()->json([
                'message' => 'Order created successfully.',
                'order'   => $order,
            ], 200);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }

    private function generateServiceNumber(): string
    {
        $lastOrderId = Order::max('id') + 1;
        $serviceNumber = 'SRV' . str_pad($lastOrderId, 6, '0', STR_PAD_LEFT);

        while (Order::where('service_number', $serviceNumber)->exists()) {
            $lastOrderId++;
            $serviceNumber = 'SRV' . str_pad($lastOrderId, 6, '0', STR_PAD_LEFT);
        }

        return $serviceNumber;
    }

    public function myOrders()
    {
        try {
            $user = sanctum()->user();

            $query = Order::with(['product', 'work', 'requester', 'provider', 'city_from', 'city_to']);

            if ($user->type === 'doctor') {
                $orders = $query->where('requester_id', $user->id)->orderBy('id', 'desc')->paginate(10);
            } else {
                $orders = $query->where('provider_id', $user->id)->orderBy('id', 'desc')->paginate(10);
            }

            $data = OrderResource::collection($orders)->response()->getData(true);
            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }
}
