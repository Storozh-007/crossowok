<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KROSS SHOP – Магазин кросівок' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-brand-white text-brand-black">

    {{-- HEADER --}}
    <header class="w-full flex justify-between items-center px-10 py-6 border-b border-brand-black/10">
        <a href="{{ route('home') }}" class="flex flex-col">
            <span class="text-5xl font-display tracking-tight">KROSS.</span>
            <span class="text-xs font-mono tracking-widest">MODERN SNEAKER ARCHIVE</span>
        </a>

        {{-- CART COUNTER --}}
        @php
            $cartCount = session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0;
        @endphp

        <nav class="flex items-center gap-6 text-sm font-mono">

            {{-- CATALOG --}}
            <a href="{{ route('products.index') }}" class="hover:text-brand-accent transition">
                CATALOG
            </a>

            {{-- CART ICON --}}
            <a href="{{ route('cart.index') }}" class="relative hover:text-brand-accent transition flex items-center">
                <span class="text-2xl">🛒</span>

                @if($cartCount > 0)
                    <span class="absolute -top-2 -right-3 bg-brand-black text-brand-white text-[10px] rounded-full px-1.5 py-0.5">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>

            {{-- PROFILE --}}
            @auth
                <a href="{{ route('profile.edit') }}" class="hover:text-brand-accent transition font-mono text-sm">
                    PROFILE
                </a>
            @endauth

            {{-- LOGIN --}}
            @guest
                <a href="{{ route('login') }}" class="hover:text-brand-accent transition">LOGIN</a>
            @endguest

            {{-- ADMIN --}}
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                    class="hover:text-brand-accent transition font-mono text-sm">
                        ADMIN PANEL
                    </a>
                @endif

                @if(auth()->user()->isGod())
                    <a href="{{ route('god.panel') }}"
                    class="hover:text-brand-accent transition font-mono text-sm">
                        GOD MODE
                    </a>
                @endif
            @endauth

            {{-- LOGOUT --}}
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="hover:text-brand-accent transition">LOGOUT</button>
                </form>
            @endauth
        </nav>
    </header>

    {{-- CONTENT --}}
    <main class="px-10 py-10">
        @yield('content')
    </main>

</body>
</html>
