@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- PAGE TITLE --}}
    <h1 class="text-5xl font-display tracking-tight mb-10">Кошик</h1>

    {{-- EMPTY CART --}}
    @if(empty($cart))
        <div class="text-center py-20">
            <p class="font-mono text-sm tracking-widest text-brand-silver mb-6">
                ВАШ КОШИК ПОРОЖНІЙ
            </p>

            <a href="{{ route('products.index') }}"
               class="inline-block border border-brand-black px-8 py-3 rounded-sm font-mono text-sm hover:bg-brand-black hover:text-white transition">
                ПОВЕРНУТИСЬ ДО МАГАЗИНУ
            </a>
        </div>
        @return
    @endif


    {{-- CART LIST --}}
    <div class="space-y-10">

        @foreach($cart as $id => $item)
            @php
                $image = $item['image']
                    ? asset('storage/' . $item['image'])
                    : asset('images/placeholder-product.svg');
            @endphp

            <div class="flex items-start gap-6 border-b border-brand-black/10 pb-8">

                {{-- IMAGE --}}
                <div class="w-40 h-40 overflow-hidden rounded-sm border border-brand-black/10">
                    <img src="{{ $image }}"
                         class="w-full h-full object-cover">
                </div>

                {{-- INFO --}}
                <div class="flex-1">

                    <h2 class="text-2xl font-display tracking-tight mb-2">
                        {{ $item['name'] }}
                    </h2>

                    <p class="font-mono text-sm text-brand-silver mb-4">
                        Ціна: ${{ $item['price'] }}
                    </p>

                    {{-- QUANTITY --}}
                    <form action="{{ route('cart.update', $id) }}" method="POST" class="inline-block">
                        @csrf
                        <input type="number" name="quantity" min="1"
                               value="{{ $item['quantity'] }}"
                               class="w-16 border-b border-brand-black focus:outline-none bg-transparent text-center font-mono text-sm">
                        <button class="font-mono text-xs ml-3 hover:text-brand-accent transition">
                            ОНОВИТИ
                        </button>
                    </form>

                    {{-- REMOVE --}}
                    <a href="{{ route('cart.remove', $id) }}"
                       class="font-mono text-xs ml-6 hover:text-brand-accent transition">
                        ВИДАЛИТИ
                    </a>

                </div>

                {{-- SUBTOTAL --}}
                <div class="text-right">
                    <p class="font-display text-xl">
                        ${{ $item['price'] * $item['quantity'] }}
                    </p>
                </div>

            </div>

        @endforeach

    </div>


    {{-- TOTAL + CHECKOUT --}}
    <div class="mt-12 pt-8 border-t border-brand-black/10 flex items-center justify-between">

        <p class="text-3xl font-display tracking-tight">
            Разом: <span class="ml-4">${{ $total }}</span>
        </p>

        <a href="{{ route('checkout.index') }}"
           class="border border-brand-black px-10 py-4 rounded-sm font-mono text-sm tracking-widest hover:bg-brand-black hover:text-white transition">
            ОФОРМИТИ ЗАМОВЛЕННЯ
        </a>

    </div>

</div>

@endsection
