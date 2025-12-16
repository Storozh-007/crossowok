@extends('layouts.app')

@section('content')

@php
    $statusColors = [
        'new' => 'bg-brand-offWhite text-brand-black',
        'paid' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
        'shipped' => 'bg-blue-100 text-blue-800 border-blue-300',
        'cancelled' => 'bg-rose-100 text-rose-800 border-rose-300',
    ];
    $maxRevenue = max(1, $monthlySeries->max('revenue') ?? 1);
@endphp

<div class="space-y-10">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="space-y-2">
            <p class="font-mono text-xs tracking-widest uppercase text-brand-silver">Control room</p>
            <h1 class="text-5xl font-display tracking-tight">Admin Dashboard</h1>
            <p class="text-sm text-brand-silver max-w-2xl">
                Жива картина магазину: виручка, замовлення, топ-продажі і статуси в одному місці.
            </p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('home') }}"
               class="border border-brand-black px-4 py-2 font-mono text-xs tracking-widest hover:bg-brand-black hover:text-white transition">
                ← На сайт
            </a>
            <a href="{{ route('admin.orders.index') }}"
               class="border border-brand-black px-4 py-2 font-mono text-xs tracking-widest bg-brand-black text-white hover:-translate-y-0.5 transition">
                Замовлення
            </a>
        </div>
    </div>

    {{-- KPI cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Виручка (all time)</p>
            <h3 class="text-3xl font-display mt-2">${{ number_format($totalRevenue, 2) }}</h3>
            <p class="text-xs text-brand-silver mt-1">Магазин тримає темп</p>
        </div>
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Замовлення</p>
            <h3 class="text-3xl font-display mt-2">{{ $ordersCount }}</h3>
            <p class="text-xs text-brand-silver mt-1">всі статуси</p>
        </div>
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Середній чек</p>
            <h3 class="text-3xl font-display mt-2">${{ number_format($avgCheck, 2) }}</h3>
            <p class="text-xs text-brand-silver mt-1">з урахуванням відмін</p>
        </div>
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Нові юзери (місяць)</p>
            <h3 class="text-3xl font-display mt-2">{{ $newUsersCount }}</h3>
            <p class="text-xs text-brand-silver mt-1">реєстрацій за {{ now()->format('F') }}</p>
        </div>
    </div>

    {{-- Ops metrics --}}
    @php
        $weekOrders = collect($ordersWeek);
        $weekOrdersCount = $weekOrders->sum('orders');
        $weekRevenue = $weekOrders->sum('revenue');
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Середніх товарів в замовленні</p>
            <h3 class="text-3xl font-display mt-2">{{ $itemsPerOrder }}</h3>
            <p class="text-xs text-brand-silver mt-1">підкаже про чек і апсейли</p>
        </div>
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Repeat клієнти</p>
            <h3 class="text-3xl font-display mt-2">{{ $repeatCustomers }}</h3>
            <p class="text-xs text-brand-silver mt-1">мають 2+ замовлення</p>
        </div>
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Замовлення (7 днів)</p>
            <h3 class="text-3xl font-display mt-2">{{ $weekOrdersCount }}</h3>
            <p class="text-xs text-brand-silver mt-1">темп останнього тижня</p>
        </div>
        <div class="p-5 border border-brand-black/10 bg-white shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Виручка (7 днів)</p>
            <h3 class="text-3xl font-display mt-2">${{ number_format($weekRevenue, 2) }}</h3>
            <p class="text-xs text-brand-silver mt-1">включно з відмінами</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Status board --}}
        <div class="border border-brand-black/10 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="font-mono text-xs tracking-widest text-brand-silver">Статуси</p>
                    <h3 class="text-2xl font-display">Order health</h3>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="font-mono text-xs underline">Деталі →</a>
            </div>
            <div class="space-y-3">
                @foreach($statusCounters as $status => $count)
                    <div class="flex items-center justify-between border border-brand-black/5 p-3 rounded-sm {{ $statusColors[$status] ?? '' }}">
                        <span class="font-mono text-xs uppercase tracking-widest">{{ $status }}</span>
                        <span class="text-xl font-display">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Revenue trend --}}
        <div class="border border-brand-black/10 bg-white p-5 shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Виручка, останні 6 міс.</p>
            <h3 class="text-2xl font-display mb-4">Revenue pulse</h3>
            <div class="space-y-3">
                @forelse($monthlySeries as $row)
                    @php
                        $width = round(($row['revenue'] / $maxRevenue) * 100);
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs font-mono mb-1 text-brand-silver">
                            <span>{{ $row['month'] }}</span>
                            <span>${{ number_format($row['revenue'], 2) }}</span>
                        </div>
                        <div class="h-2 bg-brand-offWhite relative overflow-hidden">
                            <div class="absolute left-0 top-0 h-full bg-brand-black" style="width: {{ $width }}%;"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-brand-silver">Ще немає даних.</p>
                @endforelse
            </div>
            <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                <div class="p-3 bg-brand-offWhite border border-dashed border-brand-black/20">
                    <p class="font-mono text-[11px] tracking-widest text-brand-silver">Сьогодні</p>
                    <p class="text-xl font-display">${{ number_format($todayRevenue, 2) }}</p>
                </div>
                <div class="p-3 bg-brand-offWhite border border-dashed border-brand-black/20">
                    <p class="font-mono text-[11px] tracking-widest text-brand-silver">Поточний місяць</p>
                    <p class="text-xl font-display">${{ number_format($monthRevenue, 2) }}</p>
                </div>
            </div>
        </div>

        {{-- Top products --}}
        <div class="border border-brand-black/10 bg-white p-5 shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Топ товари</p>
            <h3 class="text-2xl font-display mb-4">Що купують</h3>

            <div class="space-y-3">
                @forelse($topProducts as $item)
                    <div class="flex items-center justify-between border border-brand-black/5 p-3">
                        <div>
                            <p class="font-display">{{ $item->product->name ?? 'Товар видалено' }}</p>
                            <p class="font-mono text-xs text-brand-silver">Qty: {{ $item->qty }} • ${{ number_format($item->revenue, 2) }}</p>
                        </div>
                        <span class="font-display text-lg">#{{ $loop->iteration }}</span>
                    </div>
                @empty
                    <p class="text-sm text-brand-silver">Даних поки немає.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Latest orders --}}
        <div class="border border-brand-black/10 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="font-mono text-xs tracking-widest text-brand-silver">Найсвіжіші</p>
                    <h3 class="text-2xl font-display">Останні замовлення</h3>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="font-mono text-xs underline">Всі →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentOrders as $order)
                    <div class="flex items-center justify-between border border-brand-black/5 p-3">
                        <div>
                            <p class="font-display text-lg">#{{ $order->id }} · ${{ number_format($order->total_price, 2) }}</p>
                            <p class="font-mono text-xs text-brand-silver">
                                {{ $order->customer_name }} • {{ $order->created_at->format('d.m H:i') }}
                            </p>
                        </div>
                        <span class="font-mono text-[11px] uppercase px-2 py-1 border {{ $statusColors[$order->status] ?? 'bg-brand-offWhite' }}">
                            {{ $order->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-brand-silver">Замовлень поки немає.</p>
                @endforelse
            </div>
        </div>

        {{-- Categories performance --}}
        <div class="border border-brand-black/10 bg-white p-5 shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Категорії</p>
            <h3 class="text-2xl font-display mb-4">Куди йде попит</h3>

            <div class="space-y-3">
                @forelse($topCategories as $category)
                    <div class="flex items-center justify-between border border-brand-black/5 p-3">
                        <div>
                            <p class="font-display">{{ $category->name }}</p>
                            <p class="font-mono text-xs text-brand-silver">Продажів: {{ $category->qty }}</p>
                        </div>
                        <span class="font-display text-lg">#{{ $loop->iteration }}</span>
                    </div>
                @empty
                    <p class="text-sm text-brand-silver">Потрібно більше даних.</p>
                @endforelse
            </div>
        </div>

        {{-- Top customers --}}
        <div class="border border-brand-black/10 bg-white p-5 shadow-sm">
            <p class="font-mono text-xs tracking-widest text-brand-silver">Клієнти</p>
            <h3 class="text-2xl font-display mb-4">Топ покупці</h3>

            <div class="space-y-3">
                @forelse($topCustomers as $customer)
                    <div class="flex items-center justify-between border border-brand-black/5 p-3">
                        <div>
                            <p class="font-display">{{ $customer->user->name ?? 'Гість' }}</p>
                            <p class="font-mono text-xs text-brand-silver">Замовлень: {{ $customer->orders }} • ${{ number_format($customer->spent, 2) }}</p>
                        </div>
                        <span class="font-display text-lg">#{{ $loop->iteration }}</span>
                    </div>
                @empty
                    <p class="text-sm text-brand-silver">Ще немає клієнтів.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Weekly operations --}}
    <div class="border border-brand-black/10 bg-white p-5 shadow-sm">
        <p class="font-mono text-xs tracking-widest text-brand-silver">Тиждень</p>
        <h3 class="text-2xl font-display mb-4">Замовлення по днях</h3>
        <div class="grid grid-cols-1 md:grid-cols-7 gap-3">
            @foreach($ordersWeek as $day)
                <div class="border border-dashed border-brand-black/10 p-3 bg-brand-offWhite/60">
                    <div class="font-mono text-[11px] uppercase text-brand-silver mb-1">{{ $day['label'] }}</div>
                    <div class="text-2xl font-display">{{ $day['orders'] }}</div>
                    <div class="font-mono text-[11px] text-brand-silver">${{ number_format($day['revenue'], 0) }}</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.products.create') }}"
           class="p-5 border border-brand-black bg-brand-offWhite hover:bg-brand-black hover:text-white transition">
            <h4 class="text-xl font-display">+ Додати товар</h4>
            <p class="font-mono text-xs mt-2">Нова позиція в каталозі</p>
        </a>
        <a href="{{ route('admin.categories.index') }}"
           class="p-5 border border-brand-black bg-white hover:bg-brand-black hover:text-white transition">
            <h4 class="text-xl font-display">Категорії</h4>
            <p class="font-mono text-xs mt-2">Структура і описи</p>
        </a>
        <a href="{{ route('admin.products.index') }}"
           class="p-5 border border-brand-black bg-white hover:bg-brand-black hover:text-white transition">
            <h4 class="text-xl font-display">Каталог</h4>
            <p class="font-mono text-xs mt-2">Редагування і ціни</p>
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="p-5 border border-brand-black bg-white hover:bg-brand-black hover:text-white transition">
            <h4 class="text-xl font-display">Користувачі</h4>
            <p class="font-mono text-xs mt-2">Ролі, частота покупок</p>
        </a>
    </div>

</div>

@endsection
