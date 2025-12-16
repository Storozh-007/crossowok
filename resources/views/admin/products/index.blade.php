@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-4xl font-display tracking-tight">Товари</h1>

        <a href="{{ route('admin.products.create') }}"
           class="border border-brand-black px-6 py-3 rounded-sm font-mono text-sm tracking-widest hover:bg-brand-black hover:text-white transition">
            + ДОДАТИ ТОВАР
        </a>
    </div>

    {{-- PRODUCT GRID --}}
    <div class="grid grid-cols-4 gap-8">

        @foreach ($products as $product)
            @php
                $image = $product->image
                    ? asset('storage/' . $product->image)
                    : asset('images/placeholder-product.svg');
            @endphp
            <div class="group border border-brand-black/20 rounded-sm p-3 shadow-sm hover:shadow-md transition">

                {{-- IMAGE --}}
                <div class="w-full aspect-square overflow-hidden rounded-sm mb-4">
                    <img src="{{ $image }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>

                {{-- NAME --}}
                <h2 class="font-display text-lg mb-1">
                    {{ $product->name }}
                </h2>

                {{-- PRICE --}}
                <p class="font-mono text-sm text-brand-silver mb-4">
                    ${{ $product->price }}
                </p>

                {{-- BUTTONS --}}
                <div class="flex items-center justify-between">

                    {{-- EDIT --}}
                    <a href="{{ route('admin.products.edit', $product->id) }}"
                       class="text-xs font-mono border border-brand-black px-3 py-1 rounded-sm hover:bg-brand-black hover:text-white transition">
                        EDIT
                    </a>

                    {{-- DELETE --}}
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                          onsubmit="return confirm('Видалити товар?')">
                        @csrf
                        @method('DELETE')
                        <button
                            class="text-xs font-mono border border-brand-black px-3 py-1 rounded-sm hover:bg-brand-accent hover:text-white transition">
                            DELETE
                        </button>
                    </form>

                </div>

            </div>
        @endforeach

    </div>

</div>

@endsection
