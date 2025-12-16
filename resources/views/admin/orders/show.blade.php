@extends('layouts.app')

@section('content')

@php
    $statusColors = [
        'new' => 'bg-brand-offWhite text-brand-black',
        'paid' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
        'shipped' => 'bg-blue-100 text-blue-800 border-blue-300',
        'cancelled' => 'bg-rose-100 text-rose-800 border-rose-300',
    ];
@endphp

<div class="max-w-5xl mx-auto space-y-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="font-mono text-xs underline">← назад до списку</a>
            <h1 class="text-4xl font-display tracking-tight mt-2">Замовлення #{{ $order->id }}</h1>
            <p class="text-sm text-brand-silver">Створено {{ $order->created_at->format('d.m.Y H:i') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <span class="font-mono text-[11px] uppercase px-3 py-2 border {{ $statusColors[$order->status] ?? 'bg-brand-offWhite' }}">
                {{ $order->status }}
            </span>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex items-center gap-2">
                @csrf
                @method('PATCH')
                <select name="status" class="font-mono text-xs bg-white border border-brand-black/20">
                    @foreach(\App\Models\Order::STATUSES as $state)
                        <option value="{{ $state }}" @selected($order->status === $state)>{{ strtoupper($state) }}</option>
                    @endforeach
                </select>
                <button class="text-xs border border-brand-black px-3 py-2 hover:bg-brand-black hover:text-white transition">
                    Оновити
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="border border-emerald-300 bg-emerald-50 text-emerald-800 px-4 py-3 font-mono text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="border border-brand-black/10 bg-white p-5 shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver uppercase">Клієнт</p>
            <h3 class="text-2xl font-display mt-1">{{ $order->customer_name }}</h3>
            <div class="mt-3 space-y-2 text-sm">
                <div class="font-mono">Email: {{ $order->customer_email }}</div>
                <div class="font-mono">Телефон: {{ $order->customer_phone }}</div>
                <div class="font-mono">Адреса: {{ $order->customer_address }}</div>
                <div class="font-mono">
                    Акаунт:
                    @if($order->user)
                        <span class="font-bold">{{ $order->user->email }}</span>
                    @else
                        Гість
                    @endif
                </div>
            </div>
        </div>

        <div class="border border-brand-black/10 bg-white p-5 shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver uppercase">Оплата та сума</p>
            <div class="mt-3 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-mono text-xs text-brand-silver uppercase">Payment</span>
                    <span class="font-display">{{ $order->payment_method ?? 'card' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-mono text-xs text-brand-silver uppercase">Total</span>
                    <span class="text-3xl font-display">${{ number_format($order->total_price, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="border border-brand-black/10 bg-white shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-brand-offWhite uppercase text-xs font-mono tracking-widest">
                <tr>
                    <th class="px-4 py-3">Товар</th>
                    <th class="px-4 py-3">Qty</th>
                    <th class="px-4 py-3">Ціна</th>
                    <th class="px-4 py-3 text-right">Сума</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr class="border-t border-brand-black/10">
                        <td class="px-4 py-3">
                            <div class="font-display">{{ $item->product->name ?? 'Видалений товар' }}</div>
                            <div class="font-mono text-xs text-brand-silver">
                                {{ $item->product->category->name ?? '—' }}
                            </div>
                        </td>
                        <td class="px-4 py-3 font-mono text-xs">{{ $item->quantity }}</td>
                        <td class="px-4 py-3 font-mono text-xs">${{ number_format($item->price, 2) }}</td>
                        <td class="px-4 py-3 font-display text-right">
                            ${{ number_format($item->price * $item->quantity, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
