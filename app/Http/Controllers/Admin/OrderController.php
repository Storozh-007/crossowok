<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        if ($status && ! in_array($status, Order::STATUSES, true)) {
            $status = null;
        }

        $ordersQuery = Order::with('user')
            ->latest();

        if ($status) {
            $ordersQuery->where('status', $status);
        }

        $orders = $ordersQuery->paginate(12)->withQueryString();

        $counters = [
            'all' => Order::count(),
        ];

        foreach (Order::STATUSES as $state) {
            $counters[$state] = Order::where('status', $state)->count();
        }

        return view('admin.orders.index', compact('orders', 'status', 'counters'));
    }

    public function show(Order $order)
    {
        $order->load('items.product.category', 'user');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'in:' . implode(',', Order::STATUSES)],
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Статус замовлення оновлено.');
    }
}
