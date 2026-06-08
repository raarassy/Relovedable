<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Relovedable') — Hemat, Stylish, Ramah Lingkungan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-800 antialiased flex flex-col">

    <nav class="sticky top-0 z-40 bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 h-14 flex items-center gap-6">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-1.5 shrink-0">
                <span class="grid place-items-center w-8 h-8 rounded-lg bg-relove-500 text-white font-black text-base">R</span>
                <span class="text-base font-extrabold text-relove-600 tracking-tight">Relovedable</span>
            </a>

            {{-- Nav links --}}
            <div class="flex items-center gap-1 hidden sm:flex">
                <a href="{{ url('/') }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ request()->is('/') || request()->is('') ? 'text-relove-600 bg-relove-50' : 'text-gray-500 hover:text-relove-600 hover:bg-relove-50' }}">Home</a>
                <a href="{{ url('/katalog') }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ request()->is('katalog*') ? 'text-relove-600 bg-relove-50' : 'text-gray-500 hover:text-relove-600 hover:bg-relove-50' }}">Jelajahi</a>
                @auth
                @unless(auth()->user()->isAdmin())
                <a href="{{ url('/chat') }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ request()->is('chat*') ? 'text-relove-600 bg-relove-50' : 'text-gray-500 hover:text-relove-600 hover:bg-relove-50' }}">Chat</a>
                @endunless
                @endauth
            </div>

            <div class="flex items-center gap-2 ml-auto">
                @guest
                    <a href="{{ url('/login') }}" class="text-sm font-semibold text-gray-600 hover:text-relove-600 px-3 py-1.5">Masuk</a>
                    <a href="{{ url('/register') }}" class="rounded-full bg-relove-500 hover:bg-relove-600 text-white text-sm font-semibold px-4 py-1.5">Daftar</a>
                @else
                    @unless(auth()->user()->isAdmin())
                    <a href="{{ url('/favorit') }}" title="Favorit"
                       class="grid place-items-center w-9 h-9 rounded-full transition {{ request()->is('favorit*') ? 'text-relove-500 bg-relove-50' : 'text-gray-500 hover:text-relove-500 hover:bg-relove-50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                    </a>
                    @endunless

                    <details class="relative">
                        <summary class="list-none cursor-pointer">
                            @php($u = auth()->user())
                            @if($u->foto_profil)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($u->foto_profil) }}"
                                     class="w-9 h-9 rounded-full object-cover border-2 border-relove-200">
                            @else
                                <span class="grid place-items-center w-9 h-9 rounded-full bg-relove-100 text-relove-600 font-bold text-sm">{{ strtoupper(substr($u->nama, 0, 1)) }}</span>
                            @endif
                        </summary>
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 text-sm z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="font-semibold truncate text-gray-800">{{ $u->nama }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ '@' . $u->username }}</p>
                            </div>
                            <a href="{{ url('/profil') }}" class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:bg-relove-50 hover:text-relove-600">Profil Saya</a>
                            @unless($u->isAdmin())
                            <a href="{{ url('/favorit') }}" class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:bg-relove-50 hover:text-relove-600">Favorit Saya</a>
                            <a href="{{ url('/chat') }}" class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:bg-relove-50 hover:text-relove-600">Pesan</a>
                            @endunless
                            @if($u->isPenjual() && $u->toko)
                                <a href="{{ url('/toko/' . $u->toko->id_toko) }}" class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:bg-relove-50 hover:text-relove-600">Toko Saya</a>
                                <a href="{{ url('/barang') }}" class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:bg-relove-50 hover:text-relove-600">Kelola Barang</a>
                            @elseif(!$u->isAdmin())
                                <a href="{{ url('/penjual/daftar') }}" class="flex items-center gap-2 px-4 py-2 text-relove-600 font-medium hover:bg-relove-50">Jadi Penjual</a>
                            @endif
                            @if($u->isAdmin())
                                <a href="{{ url('/admin/verifikasi') }}" class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:bg-relove-50">Verifikasi Penjual</a>
                                <a href="{{ url('/admin/akun') }}" class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:bg-relove-50">Verifikasi Akun</a>
                            @endif
                            <form action="{{ url('/logout') }}" method="POST" class="border-t border-gray-100 mt-1 pt-1">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-500 hover:bg-red-50">Keluar</button>
                            </form>
                        </div>
                    </details>
                @endguest
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if(session('success') || session('error') || $errors->any())
        <div class="max-w-7xl mx-auto w-full px-4 mt-4 space-y-2">
            @if(session('success'))
                <div class="rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    <main class="flex-1 w-full">
        @yield('content')
    </main>

    <footer class="mt-12 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="grid place-items-center w-7 h-7 rounded-lg bg-relove-500 text-white font-black text-sm">R</span>
                    <span class="font-extrabold text-relove-600">Relovedable</span>
                </div>
                <p class="text-xs text-gray-400 max-w-xs">Pilihan terbaik untuk fashion berkelanjutan. Temukan harta karun unik dan berikan kehidupan kedua bagi pakaian favoritmu.</p>
                <p class="text-xs text-gray-300 mt-3">&copy; {{ date('Y') }} Relovedable. Lovable Selection.</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-semibold text-gray-700 mb-2">Ikuti Kami</p>
                <div class="flex gap-3">
                    <a href="#" class="grid place-items-center w-8 h-8 rounded-full bg-relove-100 text-relove-600 hover:bg-relove-500 hover:text-white transition text-sm font-bold">f</a>
                    <a href="#" class="grid place-items-center w-8 h-8 rounded-full bg-relove-100 text-relove-600 hover:bg-relove-500 hover:text-white transition text-sm">IG</a>
                    <a href="#" class="grid place-items-center w-8 h-8 rounded-full bg-relove-100 text-relove-600 hover:bg-relove-500 hover:text-white transition text-sm">✕</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
