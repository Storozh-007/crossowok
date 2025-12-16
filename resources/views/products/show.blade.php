@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto py-20 px-6">
    @php
        $image = $product->image
            ? asset('storage/' . $product->image)
            : asset('images/placeholder-product.svg');
    @endphp

    {{-- BACK LINK --}}
    <a href="{{ route('products.index') }}"
       class="font-mono text-xs tracking-widest hover:text-brand-accent transition flex items-center gap-2 mb-12">
        ← повернутись до каталогу
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

        {{-- LEFT: PRODUCT IMAGE --}}
        <div class="flex justify-center">

            <div class="relative w-[350px] sm:w-[400px] md:w-[450px]">

                {{-- Decorative shadow --}}
                <div class="absolute -inset-3 bg-brand-black/5 blur-xl rounded-2xl"></div>

                <div class="relative overflow-hidden rounded-lg border border-brand-black/10 shadow-xl group">
                    <div class="aspect-[4/5] w-full overflow-hidden">
                        <img src="{{ $image }}"
                            class="w-full h-full object-cover transition duration-500 group-hover:scale-[1.03]">
                    </div>
                </div>

            </div>

        </div>

        {{-- RIGHT: PRODUCT INFO --}}
        <div class="flex flex-col justify-center">

            {{-- CATEGORY --}}
            <p class="font-mono text-xs tracking-[0.25em] text-brand-silver uppercase mb-4">
                {{ $product->category->name }}
            </p>

            {{-- NAME --}}
            <h1 class="text-5xl font-display tracking-tight leading-none mb-6">
                {{ $product->name }}
            </h1>

            {{-- PRICE --}}
            <p class="text-3xl font-display mb-10 text-brand-black">
                ${{ $product->price }}
            </p>

            {{-- DESCRIPTION --}}
            @if($product->description)
                <p class="text-base leading-relaxed text-brand-black/80 mb-12 max-w-lg">
                    {{ $product->description }}
                </p>
            @endif

            {{-- ACTION BUTTONS --}}
            <div class="flex flex-wrap items-center gap-6">

                {{-- ADD TO CART --}}
                <a href="{{ route('cart.add', $product->id) }}"
                    class="border border-brand-black px-10 py-4 rounded-sm
                        font-mono tracking-widest text-sm
                        hover:bg-brand-black hover:text-brand-white
                        transition-all duration-300">
                    ДОДАТИ В КОШИК
                </a>

                {{-- BUY NOW --}}
                <a href="{{ route('checkout.index', ['buy' => $product->id]) }}"
                    class="border border-brand-accent text-brand-accent px-10 py-4 rounded-sm
                        font-mono tracking-widest text-sm
                        hover:bg-brand-accent hover:text-white
                        transition-all duration-300">
                    КУПИТИ ЗАРАЗ
                </a>

            </div>

        </div>

    </div>

    {{-- STROKED TITLE DECORATION --}}
    <div class="mt-28 flex justify-center">
        <h2 class="stroke-text font-display text-6xl tracking-tight opacity-20 select-none">
            {{ strtoupper($product->name) }}
        </h2>
    </div>

</div>

@endsection
