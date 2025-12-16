@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Title --}}
    <h1 class="text-4xl font-display tracking-tight mb-10">Категорії</h1>

    {{-- Add category --}}
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.categories.create') }}"
           class="border border-brand-black px-6 py-3 rounded-sm font-mono text-sm tracking-widest hover:bg-brand-black hover:text-white transition">
            + ДОДАТИ КАТЕГОРІЮ
        </a>
    </div>

    {{-- Categories list --}}
    <div class="space-y-4">
        @foreach ($categories as $category)
            <div class="border border-brand-black/20 p-4 rounded-sm flex justify-between items-center">

                <div>
                    <h2 class="font-display text-lg">{{ $category->name }}</h2>
                    <p class="font-mono text-xs text-brand-silver">{{ $category->description }}</p>
                </div>

                <div class="flex gap-3">

                    {{-- Edit --}}
                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                       class="text-xs font-mono border border-brand-black px-3 py-1 rounded-sm hover:bg-brand-black hover:text-white transition">
                        EDIT
                    </a>

                    {{-- Delete --}}
                    <form action="{{ route('admin.categories.destroy', $category->id) }}"
                          method="POST" onsubmit="return confirm('Видалити категорію?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-xs font-mono border border-brand-black px-3 py-1 rounded-sm hover:bg-brand-accent hover:text-white transition">
                            DELETE
                        </button>
                    </form>

                </div>

            </div>
        @endforeach
    </div>

</div>

@endsection
