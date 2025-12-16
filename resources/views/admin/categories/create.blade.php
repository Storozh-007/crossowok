@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- Back --}}
    <a href="{{ route('admin.categories.index') }}"
       class="mb-6 flex items-center gap-2 font-mono text-xs hover:text-brand-accent transition">
        ← назад до категорій
    </a>

    {{-- Title --}}
    <h1 class="text-4xl font-display tracking-tight mb-10">Створити категорію</h1>

    {{-- Form --}}
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        {{-- Name --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">НАЗВА</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
            @error('name')
                <p class="text-brand-accent text-xs font-mono mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Slug (auto or manual) --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">SLUG</label>
            <input type="text" name="slug" value="{{ old('slug') }}" required
                   class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
            @error('slug')
                <p class="text-brand-accent text-xs font-mono mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">ОПИС</label>
            <textarea name="description" rows="3"
                      class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-brand-accent text-xs font-mono mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full border border-brand-black px-6 py-3 rounded-sm font-mono text-sm hover:bg-brand-black hover:text-white transition">
            СТВОРИТИ
        </button>

    </form>

</div>

@endsection
