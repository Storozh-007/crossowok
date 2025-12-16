@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- BACK --}}
    <a href="{{ route('admin.products.index') }}"
       class="mb-6 flex items-center gap-2 font-mono text-xs hover:text-brand-accent transition">
        ← назад до товарів
    </a>

    {{-- TITLE --}}
    <h1 class="text-4xl font-display tracking-tight mb-10">Додати товар</h1>

    {{-- FORM --}}
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- NAME --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">НАЗВА</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
            @error('name') <p class="text-brand-accent text-xs font-mono">{{ $message }}</p> @enderror
        </div>

        {{-- SLUG --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">SLUG</label>
            <input type="text" name="slug" value="{{ old('slug') }}" required
                   class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
            @error('slug') <p class="text-brand-accent text-xs font-mono">{{ $message }}</p> @enderror
        </div>

        {{-- CATEGORY --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">КАТЕГОРІЯ</label>
            <select name="category_id"
                    class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-brand-accent text-xs font-mono">{{ $message }}</p> @enderror
        </div>

        {{-- PRICE --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">ЦІНА ($)</label>
            <input type="number" name="price" step="0.01" value="{{ old('price') }}" required
                   class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
            @error('price') <p class="text-brand-accent text-xs font-mono">{{ $message }}</p> @enderror
        </div>

        {{-- DESCRIPTION --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">ОПИС</label>
            <textarea name="description" rows="4"
                      class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">{{ old('description') }}</textarea>
            @error('description') <p class="text-brand-accent text-xs font-mono">{{ $message }}</p> @enderror
        </div>

        {{-- IMAGE --}}
        <div class="mb-10">
            <label class="font-mono text-xs tracking-widest block mb-3">ЗОБРАЖЕННЯ</label>
            <input type="file" name="image"
                   class="w-full bg-transparent border border-dashed border-brand-black/40 p-4 rounded-sm hover:border-brand-black transition">
            @error('image') <p class="text-brand-accent text-xs font-mono">{{ $message }}</p> @enderror
        </div>

        {{-- SUBMIT --}}
        <button type="submit"
                class="w-full border border-brand-black px-6 py-3 rounded-sm font-mono text-sm tracking-widest hover:bg-brand-black hover:text-white transition">
            ДОДАТИ ТОВАР
        </button>

    </form>
</div>

@endsection
