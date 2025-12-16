@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- TITLE --}}
    <h1 class="text-5xl font-display tracking-tight mb-10">Оформлення замовлення</h1>

    {{-- RETURN LINK --}}
    <a href="{{ route('cart.index') }}"
       class="font-mono text-xs tracking-widest hover:text-brand-accent transition block mb-8">
        ← повернутись до кошика
    </a>

    {{-- MAIN CHECKOUT GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16">

        {{-- LEFT: FORM --}}
        <div>

            <h2 class="text-xl font-display mb-6">Ваші дані</h2>

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf

                {{-- NAME --}}
                <div class="mb-8">
                    <label class="font-mono text-xs tracking-widest block mb-2">ПОВНЕ ІМʼЯ</label>
                    <input type="text" name="customer_name" required
                           value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                           class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
                    @error('customer_name')
                        <p class="text-brand-accent text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div class="mb-8">
                    <label class="font-mono text-xs tracking-widest block mb-2">EMAIL</label>
                    <input type="email" name="customer_email" required
                           value="{{ old('customer_email', auth()->user()->email ?? '') }}"
                           class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
                    @error('customer_email')
                        <p class="text-brand-accent text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PHONE --}}
                <div class="mb-8">
                    <label class="font-mono text-xs tracking-widest block mb-2">ТЕЛЕФОН</label>
                    <input type="text" name="customer_phone" required
                           placeholder="+380 (__) ___-__-__"
                           value="{{ old('customer_phone') }}"
                           class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black">
                    @error('customer_phone')
                        <p class="text-brand-accent text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ADDRESS --}}
                <div class="mb-10">
                    <label class="font-mono text-xs tracking-widest block mb-2">АДРЕСА ДОСТАВКИ</label>
                    <textarea name="customer_address" required rows="3"
                              class="w-full bg-transparent border-b border-brand-black/40 py-2 focus:border-brand-black"
                    >{{ old('customer_address') }}</textarea>
                    @error('customer_address')
                        <p class="text-brand-accent text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SUBMIT --}}
                <button type="submit"
                        class="w-full border border-brand-black px-8 py-4 rounded-sm font-mono text-sm tracking-widest hover:bg-brand-black hover:text-white transition">
                    ПІДТВЕРДИТИ ЗАМОВЛЕННЯ
                </button>

            </form>
        </div>


        {{-- RIGHT: ORDER SUMMARY --}}
        <div>

            <h2 class="text-xl font-display mb-6">Ваше замовлення</h2>

            <div class="space-y-6">

                @foreach($cart as $item)
                    <div class="flex justify-between border-b border-brand-black/10 pb-4">

                        <div>
                            <p class="font-display text-lg">{{ $item['name'] }}</p>
                            <p class="font-mono text-sm text-brand-silver">
                                Кількість: {{ $item['quantity'] }}
                            </p>
                        </div>

                        <p class="font-display text-lg">
                            ${{ $item['price'] * $item['quantity'] }}
                        </p>

                    </div>
                @endforeach

            </div>

            {{-- TOTAL --}}
            <div class="mt-10 pt-6 border-t border-brand-black/10">
                <p class="text-3xl font-display tracking-tight">
                    Разом: ${{ $total }}
                </p>
            </div>

        </div>

    </div>

</div>

@endsection
