<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $data = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'required|email|max:255',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
        ]);

        $cart = session()->get('cart', []);
        $totalPrice = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'user_id'         => Auth::id(),
            'customer_name'   => $data['customer_name'],
            'customer_email'  => $data['customer_email'],
            'customer_phone'  => $data['customer_phone'],
            'customer_address'=> $data['customer_address'],
            'total_price'     => $totalPrice,
            'status'          => 'new',
            'payment_method'  => 'card',
        ]);

        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id'  => $order->id,
                'product_id'=> $id,
                'quantity'  => $item['quantity'],
                'price'     => $item['price'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('orders.thankyou');
    }

    public function thankyou()
    {
        return view('orders.thankyou');
    }
}
