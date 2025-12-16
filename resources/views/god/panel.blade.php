@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">

    <h1 class="text-4xl font-display mb-10">GOD MODE</h1>

    @if(session('success'))
        <p class="text-brand-accent font-mono mb-4">{{ session('success') }}</p>
    @endif

    <table class="w-full border border-brand-black/20">
        <tr class="bg-brand-offWhite text-brand-black">
            <th class="p-3 font-mono text-xs tracking-widest">USER</th>
            <th class="p-3 font-mono text-xs tracking-widest">EMAIL</th>
            <th class="p-3 font-mono text-xs tracking-widest">ROLE</th>
            <th class="p-3 font-mono text-xs tracking-widest"></th>
        </tr>

        @foreach($users as $u)
            <tr class="border-t border-brand-black/20">
                <td class="p-3">{{ $u->name }}</td>
                <td class="p-3">{{ $u->email }}</td>
                <td class="p-3 font-mono uppercase">{{ $u->role }}</td>
                <td class="p-3">

                    @if(!$u->isGod())
                        <form action="{{ route('god.setAdmin') }}" method="POST" class="flex gap-2">
                            @csrf

                            <input type="hidden" name="user_id" value="{{ $u->id }}">

                            <select name="role"
                                    class="border border-brand-black bg-transparent px-2 py-1 font-mono text-xs">
                                <option value="user">USER</option>
                                <option value="admin">ADMIN</option>
                            </select>

                            <button class="border border-brand-black px-3 py-1 text-xs font-mono hover:bg-brand-black hover:text-white transition">
                                SAVE
                            </button>
                        </form>
                    @else
                        <span class="font-mono text-brand-accent text-xs">ALMIGHTY</span>
                    @endif

                </td>
            </tr>
        @endforeach

    </table>

</div>
@endsection
