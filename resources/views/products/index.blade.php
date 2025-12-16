@extends('layouts.app')

@section('content')

<div class="flex gap-10">

    {{-- LEFT SIDEBAR --}}
    <aside class="w-64 border-r border-brand-black/10 pr-6">

        {{-- Search --}}
        <form method="GET" class="mb-10">
            <label class="font-mono text-xs tracking-widest block mb-2">ПОШУК</label>
            <input type="text" name="q" value="{{ request('q') }}"
                   class="w-full bg-transparent border-b border-brand-black focus:outline-none py-1"
                   placeholder="keyword...">
        </form>
        {{-- PRICE FILTER --}}
<div class="mb-10">
    <label class="font-mono text-xs tracking-widest block mb-3">ЦІНА (₴)</label>

    <form method="GET" class="space-y-4">

        {{-- PRICE FROM --}}
        <div>
            <input type="number"
                   name="price_from"
                   value="{{ request('price_from') }}"
                   placeholder="ВІД"
                   class="w-full bg-transparent border-b border-brand-black/40 focus:border-brand-black py-1 outline-none">
        </div>

        {{-- PRICE TO --}}
        <div>
            <input type="number"
                   name="price_to"
                   value="{{ request('price_to') }}"
                   placeholder="ДО"
                   class="w-full bg-transparent border-b border-brand-black/40 focus:border-brand-black py-1 outline-none">
        </div>

        <button type="submit"
                class="w-full border border-brand-black px-4 py-2 font-mono text-xs tracking-widest hover:bg-brand-black hover:text-brand-white transition">
            ФІЛЬТРУВАТИ
        </button>

    </form>
</div>


        {{-- Categories --}}
        <div class="mb-10">
            <label class="font-mono text-xs tracking-widest block mb-2">КАТЕГОРІЇ</label>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('products.index') }}"
                       class="hover:text-brand-accent {{ request('category') ? '' : 'font-bold' }}">
                       Усі товари
                    </a>
                </li>

                @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('products.index', ['category' => $cat->id]) }}"
                           class="hover:text-brand-accent {{ request('category') == $cat->id ? 'font-bold' : '' }}">
                           {{ $cat->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

    </aside>

    {{-- PRODUCT GRID --}}
    <section class="flex-1">

        <h2 class="mb-4 font-mono text-xs tracking-widest uppercase">
            Showing {{ $products->total() }} items
        </h2>

        <div class="grid grid-cols-3 gap-10">
            @foreach ($products as $product)
                @php
                    $image = $product->image
                        ? asset('storage/' . $product->image)
                        : asset('images/placeholder-product.svg');
                @endphp
                <a href="{{ route('products.show', $product->slug) }}" class="group space-y-2">

                    {{-- IMAGE --}}
                    <div class="w-full aspect-square overflow-hidden rounded-sm shadow-md">
                        <img src="{{ $image }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>

                    {{-- NAME --}}
                    <div class="font-display text-lg tracking-tight">
                        {{ $product->name }}
                    </div>

                    {{-- PRICE --}}
                    <div class="font-mono text-sm text-brand-silver">
                        ${{ $product->price }}
                    </div>

                </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $products->links() }}
        </div>

    </section>

</div>

@endsection
