@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto space-y-10">

    {{-- Title --}}
    <div>
        <p class="font-mono text-xs tracking-widest text-brand-silver uppercase">Account</p>
        <h1 class="text-4xl font-display tracking-tight">Мій профіль</h1>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Витрачено</p>
            <h3 class="text-3xl font-display mt-2">${{ number_format($totalSpent, 2) }}</h3>
            <p class="text-xs text-brand-silver mt-1">усі завершені замовлення</p>
        </div>
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">В процесі</p>
            <h3 class="text-3xl font-display mt-2">{{ $openOrdersCount }}</h3>
            <p class="text-xs text-brand-silver mt-1">new + paid</p>
        </div>
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Останнє замовлення</p>
            <h3 class="text-3xl font-display mt-2">{{ $lastOrder?->created_at?->format('d.m.Y') ?? '—' }}</h3>
            <p class="text-xs text-brand-silver mt-1">ідентифікатор: {{ $lastOrder?->id ?? '—' }}</p>
        </div>
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Придбані пари</p>
            <h3 class="text-3xl font-display mt-2">{{ $itemsBought }}</h3>
            <p class="text-xs text-brand-silver mt-1">за весь час</p>
        </div>
    </div>

    {{-- Success --}}
    @if(session('success'))
        <div class="mb-4 text-brand-accent font-mono text-sm border border-brand-accent/40 bg-brand-offWhite px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <form action="{{ route('profile.update') }}" method="POST" class="bg-white border border-brand-black/10 p-6 shadow-sm">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-8">
                <label class="font-mono text-xs tracking-widest block mb-2">ІМʼЯ</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
                @error('name') <p class="text-brand-accent text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div class="mb-8">
                <label class="font-mono text-xs tracking-widest block mb-2">EMAIL</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
                @error('email') <p class="text-brand-accent text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div class="mb-8">
                <label class="font-mono text-xs tracking-widest block mb-2">НОВИЙ ПАРОЛЬ</label>
                <input type="password" name="password"
                       class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
                <p class="font-mono text-xs mt-1 text-brand-silver">* залиш порожнім, якщо не хочеш змінювати</p>
                @error('password') <p class="text-brand-accent text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Confirm --}}
            <div class="mb-10">
                <label class="font-mono text-xs tracking-widest block mb-2">ПІДТВЕРДЖЕННЯ ПАРОЛЯ</label>
                <input type="password" name="password_confirmation"
                       class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full border border-brand-black px-6 py-3 rounded-sm font-mono text-sm hover:bg-brand-black hover:text-white transition">
                ОНОВИТИ ПРОФІЛЬ
            </button>

        </form>

        {{-- Order history --}}
        <div class="bg-white border border-brand-black/10 p-6 shadow-sm">
            @php
                $statusColors = [
                    'new' => 'bg-brand-offWhite text-brand-black',
                    'paid' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                    'shipped' => 'bg-blue-100 text-blue-800 border-blue-300',
                    'cancelled' => 'bg-rose-100 text-rose-800 border-rose-300',
                ];
            @endphp

            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="font-mono text-xs tracking-widest text-brand-silver uppercase">Мої замовлення</p>
                    <h3 class="text-2xl font-display">Історія покупок</h3>
                </div>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.orders.index') }}" class="font-mono text-xs underline">адмін</a>
                @endif
            </div>

            <div class="space-y-3 max-h-[360px] overflow-y-auto hide-scrollbar pr-1">
                @forelse($orders as $order)
                    <div class="border border-brand-black/10 p-3 flex items-center justify-between">
                        <div>
                            <p class="font-display">#{{ $order->id }} · ${{ number_format($order->total_price, 2) }}</p>
                            <p class="font-mono text-xs text-brand-silver">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <span class="font-mono text-[11px] uppercase px-3 py-1 border {{ $statusColors[$order->status] ?? 'bg-brand-offWhite' }}">
                            {{ $order->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-brand-silver">Ти ще нічого не купував.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>

@endsection
