<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $orders = $user->orders()
            ->with('items.product')
            ->latest()
            ->get();

        $totalSpent = $orders->sum('total_price');
        $openOrdersCount = $orders->whereIn('status', ['new', 'paid'])->count();
        $lastOrder = $orders->first();
        $itemsBought = $orders->flatMap->items->sum('quantity');

        return view('profile.edit', compact(
            'user',
            'orders',
            'totalSpent',
            'openOrdersCount',
            'lastOrder',
            'itemsBought'
        ));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255'],
            'password' => ['nullable', 'confirmed', 'min:6'],
        ]);

        // якщо пароль введено — оновлюємо
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // не чіпаємо старий пароль
        }

        $user->update($data);

        return back()->with('success', 'Профіль успішно оновлено!');
    }
}
