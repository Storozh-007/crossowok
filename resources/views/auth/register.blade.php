@extends('layouts.guest')

@section('content')

<div class="w-full max-w-md bg-brand-white shadow-xl border border-brand-black/20 p-10">

    {{-- BACK --}}
    <a href="{{ route('login') }}"
       class="mb-6 flex items-center gap-2 font-mono text-xs hover:text-brand-accent transition">
        ← назад
    </a>

    {{-- TITLE --}}
    <h1 class="text-5xl font-display tracking-tight mb-10">SIGN UP</h1>

    <form action="{{ route('register.post') }}" method="POST">
        @csrf

        {{-- NAME --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">FULL NAME</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full bg-transparent border-b border-brand-black/40 focus:border-brand-black focus:outline-none py-2">
            @error('name')
                <p class="text-brand-accent text-xs font-mono mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- EMAIL --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">EMAIL ADDRESS</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full bg-transparent border-b border-brand-black/40 focus:border-brand-black focus:outline-none py-2">
            @error('email')
                <p class="text-brand-accent text-xs font-mono mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- PASSWORD --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">PASSWORD</label>
            <input type="password" name="password" required
                   class="w-full bg-transparent border-b border-brand-black/40 focus:border-brand-black focus:outline-none py-2">
            @error('password')
                <p class="text-brand-accent text-xs font-mono mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">CONFIRM PASSWORD</label>
            <input type="password" name="password_confirmation" required
                   class="w-full bg-transparent border-b border-brand-black/40 focus:border-brand-black focus:outline-none py-2">
        </div>


        {{-- BUTTON --}}
        <button type="submit"
                class="w-full border border-brand-black px-6 py-3 rounded-sm font-mono text-sm tracking-widest hover:bg-brand-black hover:text-brand-white transition">
            CREATE ACCOUNT
        </button>

        {{-- LOGIN LINK --}}
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}"
               class="font-mono text-xs tracking-widest hover:text-brand-accent transition">
                Already have an account? LOGIN
            </a>
        </div>

    </form>

</div>

@endsection
