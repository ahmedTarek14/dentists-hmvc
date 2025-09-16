<?php

namespace Modules\Order\Http\Controllers\Dashboard;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Entities\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['product', 'work', 'requester', 'provider', 'city_from', 'city_to'])
            ->latest()
            ->paginate(10);

        return view('order::index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['product', 'work', 'requester', 'provider', 'city_from', 'city_to']);
        return view('order::show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,delivered,canceled'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'تم تحديث حالة الأوردر بنجاح');
    }
}
