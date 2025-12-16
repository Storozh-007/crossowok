@extends('layouts.guest')

@section('content')

<div class="w-full max-w-md bg-brand-white shadow-xl border border-brand-black/20 p-10 relative">

    {{-- BACK LINK --}}
    <a href="{{ route('home') }}"
   class="mb-6 flex items-center gap-2 font-mono text-xs hover:text-brand-accent transition">
    ← повернутись
</a>


    {{-- TITLE --}}
    <h1 class="text-5xl font-display tracking-tight mb-10">ACCESS</h1>

    {{-- SESSION STATUS --}}
    @if(session('status'))
        <div class="mb-4 text-brand-accent font-mono text-sm">
            {{ session('status') }}
        </div>
    @endif

    {{-- LOGIN FORM --}}
    <form action="{{ route('login.post') }}" method="POST">
        @csrf

        {{-- EMAIL --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">EMAIL ADDRESS</label>
            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   class="w-full bg-transparent border-b border-brand-black/40 focus:border-brand-black focus:outline-none py-2">
            @error('email')
                <p class="text-brand-accent text-xs font-mono mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- PASSWORD --}}
        <div class="mb-8">
            <label class="font-mono text-xs tracking-widest block mb-2">PASSWORD</label>
            <input type="password"
                   name="password"
                   required
                   class="w-full bg-transparent border-b border-brand-black/40 focus:border-brand-black focus:outline-none py-2">
            @error('password')
                <p class="text-brand-accent text-xs font-mono mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- REMEMBER ME --}}
        <div class="flex items-center gap-2 mb-8">
            <input type="checkbox" name="remember" class="w-4 h-4 border-brand-black">
            <label class="font-mono text-xs tracking-widest">REMEMBER ME</label>
        </div>

        {{-- SUBMIT BUTTON --}}
        <button type="submit"
                class="w-full border border-brand-black px-6 py-3 rounded-sm font-mono text-sm tracking-widest hover:bg-brand-black hover:text-brand-white transition">
            LOGIN
        </button>

        {{-- OPTIONAL SIGN-UP NOTICE (disabled) --}}
        <div class="mt-6 text-center">
            <span class="font-mono text-xs tracking-widest text-brand-silver">
                NO ACCOUNT? ACCESS RESTRICTED
            </span>
        </div>
        {{-- SIGN UP BUTTON --}}
<div class="mt-6 text-center">
    <a href="{{ route('register') }}"
       class="inline-block border border-brand-black px-6 py-3 rounded-sm font-mono text-sm tracking-widest hover:bg-brand-black hover:text-brand-white transition">
        SIGN UP
    </a>
</div>

    </form>

</div>

@endsection
