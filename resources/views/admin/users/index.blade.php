@extends('layouts.app')

@section('content')

<div class="space-y-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="font-mono text-xs tracking-widest text-brand-silver uppercase">People</p>
            <h1 class="text-4xl font-display tracking-tight">Користувачі та ролі</h1>
            <p class="text-sm text-brand-silver max-w-2xl">Живий зріз по всіх зареєстрованих юзерах, їхніх замовленнях та ролях.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="font-mono text-xs underline">← назад у дашборд</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Усього акаунтів</p>
            <h3 class="text-3xl font-display mt-2">{{ $totalUsers }}</h3>
            <p class="text-xs text-brand-silver mt-1">включно з адміністраторами</p>
        </div>
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Адмінів</p>
            <h3 class="text-3xl font-display mt-2">{{ $adminCount }}</h3>
            <p class="text-xs text-brand-silver mt-1">керування магазином</p>
        </div>
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Нові цього місяця</p>
            <h3 class="text-3xl font-display mt-2">{{ $newThisMonth }}</h3>
            <p class="text-xs text-brand-silver mt-1">з {{ now()->format('F') }}</p>
        </div>
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Повторні клієнти</p>
            <h3 class="text-3xl font-display mt-2">{{ $repeatCustomers }}</h3>
            <p class="text-xs text-brand-silver mt-1">мають 2+ замовлень</p>
        </div>
    </div>

    @if($topSpender)
        <div class="border border-brand-black/10 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="font-mono text-xs tracking-widest text-brand-silver uppercase">Top buyer</p>
                    <h3 class="text-2xl font-display">{{ $topSpender->name }}</h3>
                </div>
                <span class="font-mono text-[11px] uppercase px-3 py-1 border border-brand-black/10 bg-brand-offWhite">{{ $topSpender->role }}</span>
            </div>
            <p class="font-mono text-sm text-brand-silver">Сума покупок: ${{ number_format($topSpender->total_spent ?? 0, 2) }} · Замовлень: {{ $topSpender->orders_count }}</p>
        </div>
    @endif

    <div class="border border-brand-black/10 bg-white shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-brand-offWhite uppercase text-xs font-mono tracking-widest">
                <tr>
                    <th class="px-4 py-3">Користувач</th>
                    <th class="px-4 py-3">Роль</th>
                    <th class="px-4 py-3">Замовлення</th>
                    <th class="px-4 py-3">Сума</th>
                    <th class="px-4 py-3">Останнє замовлення</th>
                    <th class="px-4 py-3">Зареєстрований</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-t border-brand-black/10">
                        <td class="px-4 py-3">
                            <div class="font-display">{{ $user->name }}</div>
                            <div class="font-mono text-xs text-brand-silver">{{ $user->email }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-mono text-[11px] uppercase px-2 py-1 border border-brand-black/10 bg-brand-offWhite">{{ $user->role }}</span>
                        </td>
                        <td class="px-4 py-3 font-display">{{ $user->orders_count }}</td>
                        <td class="px-4 py-3 font-display">${{ number_format($user->total_spent ?? 0, 2) }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-brand-silver">
                            {{ optional($user->orders->first())->created_at?->format('d.m.Y H:i') ?? '—' }}
                        </td>
                        <td class="px-4 py-3 font-mono text-xs text-brand-silver">{{ $user->created_at->format('d.m.Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-brand-silver font-mono text-sm">Немає користувачів.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
