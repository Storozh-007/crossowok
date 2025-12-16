@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- BACK --}}
    <a href="{{ route('admin.products.index') }}"
       class="mb-6 flex items-center gap-2 font-mono text-xs hover:text-brand-accent transition">
        ← назад до товарів
    </a>

    {{-- TITLE --}}
    <h1 class="text-4xl font-display tracking-tight mb-10">Редагувати товар</h1>

    {{-- FORM --}}
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @php
            $image = $product->image
                ? asset('storage/' . $product->image)
                : asset('images/placeholder-product.svg');
        @endphp

        {{-- NAME --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">НАЗВА</label>
            <input type="text" name="name" value="{{ $product->name }}" required
                   class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
            @error('name') <p class="text-brand-accent text-xs font-mono">{{ $message }}</p> @enderror
        </div>

        {{-- SLUG --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">SLUG</label>
            <input type="text" name="slug" value="{{ $product->slug }}" required
                   class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
            @error('slug') <p class="text-brand-accent text-xs font-mono">{{ $message }}</p> @enderror
        </div>

        {{-- PRICE --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">ЦІНА</label>
            <input type="number" step="0.01" name="price" value="{{ $product->price }}" required
                   class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
            @error('price') <p class="text-brand-accent text-xs font-mono">{{ $message }}</p> @enderror
        </div>

        {{-- CATEGORY --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">КАТЕГОРІЯ</label>
            <select name="category_id"
                    class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected($cat->id == $product->category_id)>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-brand-accent text-xs font-mono">{{ $message }}</p> @enderror
        </div>

        {{-- DESCRIPTION --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">ОПИС</label>
            <textarea name="description" rows="3"
                class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">{{ $product->description }}</textarea>
            @error('description') <p class="text-brand-accent text-xs font-mono">{{ $message }}</p> @enderror
        </div>

        {{-- IMAGE --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">ФОТО</label>
            <input type="file" name="image" class="block w-full text-sm">
            @error('image') <p class="text-brand-accent text-xs font-mono">{{ $message }}</p> @enderror

            <div class="mt-4">
                <img src="{{ $image }}" class="w-40 rounded">
            </div>
        </div>

        {{-- SUBMIT --}}
        <button type="submit"
                class="w-full border border-brand-black px-6 py-3 rounded-sm font-mono text-sm hover:bg-brand-black hover:text-white transition">
            ОНОВИТИ
        </button>

    </form>

</div>

@endsection
