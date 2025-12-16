@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto text-center py-20">

    {{-- BIG TITLE --}}
    <h1 class="text-6xl font-display tracking-tight mb-6">
        Дякуємо!
    </h1>

    {{-- SUBTEXT --}}
    <p class="font-mono text-sm tracking-widest text-brand-silver mb-12">
        ВАШЕ ЗАМОВЛЕННЯ УСПІШНО ОФОРМЛЕНО
    </p>

    {{-- ICON / EMOJI --}}
    <div class="text-7xl mb-12">
        🛒✨
    </div>

    {{-- MESSAGE --}}
    <p class="font-sans text-lg text-brand-black leading-relaxed mb-10">
        Ми вже розпочали обробку вашого замовлення.<br>
        Найближчим часом ви отримаєте підтвердження на email.
    </p>

    {{-- BUTTONS --}}
    <div class="flex items-center justify-center gap-6">

        {{-- go home --}}
        <a href="{{ route('home') }}"
           class="border border-brand-black px-10 py-4 rounded-sm font-mono text-sm tracking-widest hover:bg-brand-black hover:text-white transition">
            НА ГОЛОВНУ
        </a>

        {{-
