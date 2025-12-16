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

<div class="space-y-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="font-mono text-xs tracking-widest text-brand-silver uppercase">Operations</p>
            <h1 class="text-4xl font-display tracking-tight">Замовлення</h1>
            <p class="text-sm text-brand-silver">Швидке керування статусами і деталями клієнтів.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="font-mono text-xs underline">← назад в дашборд</a>
    </div>

    @if(session('success'))
        <div class="border border-emerald-300 bg-emerald-50 text-emerald-800 px-4 py-3 font-mono text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.orders.index') }}"
           class="px-3 py-2 border {{ $status ? 'border-brand-black/20 text-brand-silver' : 'border-brand-black bg-brand-black text-white' }} font-mono text-xs tracking-widest">
            All ({{ $counters['all'] ?? 0 }})
        </a>
        @foreach(\App\Models\Order::STATUSES as $state)
            <a href="{{ route('admin.orders.index', ['status' => $state]) }}"
               class="px-3 py-2 border border-brand-black/20 font-mono text-xs tracking-widest {{ $status === $state ? 'bg-brand-black text-white' : 'bg-white' }}">
                {{ strtoupper($state) }} ({{ $counters[$state] ?? 0 }})
            </a>
        @endforeach
    </div>

    <div class="border border-brand-black/10 bg-white shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-brand-offWhite uppercase text-xs font-mono tracking-widest">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Клієнт</th>
                    <th class="px-4 py-3">Сума</th>
                    <th class="px-4 py-3">Статус</th>
                    <th class="px-4 py-3">Створено</th>
                    <th class="px-4 py-3 text-right">Дії</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-t border-brand-black/10">
                        <td class="px-4 py-3 font-display">#{{ $order->id }}</td>
                        <td class="px-4 py-3">
                            <div class="font-display">{{ $order->customer_name }}</div>
                            <div class="font-mono text-xs text-brand-silver">{{ $order->customer_email }}</div>
                        </td>
                        <td class="px-4 py-3 font-display">${{ number_format($order->total_price, 2) }}</td>
                        <td class="px-4 py-3">
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="font-mono text-xs bg-white border border-brand-black/20">
                                    @foreach(\App\Models\Order::STATUSES as $state)
                                        <option value="{{ $state }}" @selected($order->status === $state)>{{ strtoupper($state) }}</option>
                                    @endforeach
                                </select>
                                <button class="text-xs border border-brand-black px-2 py-1 hover:bg-brand-black hover:text-white transition">
                                    OK
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3 font-mono text-xs text-brand-silver">
                            {{ $order->created_at->format('d.m H:i') }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="font-mono text-xs underline">Деталі</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-brand-silver font-mono text-sm">
                            Замовлень поки немає.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $orders->links() }}
    </div>

</div>

@endsection
