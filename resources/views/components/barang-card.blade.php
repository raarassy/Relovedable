@props(['barang'])

@php
    $foto      = $barang->fotoBarangs->first();
    $isFav     = auth()->check() ? $barang->difavoritkanOleh(auth()->id()) : false;
    $rating    = $barang->toko ? $barang->toko->ratingRata() : null;
    $lokasi    = $barang->toko?->alamat_toko;

    $kondisiLabel = [
        'baru'         => 'Baru',
        'seperti_baru' => 'Seperti Baru',
        'bekas'        => 'Bekas Layak',
    ][$barang->kondisi] ?? ucfirst($barang->kondisi);
@endphp

<div class="group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">

    {{-- Gambar --}}
    <a href="{{ url('/barang/' . $barang->id_barang) }}" class="block relative">
        <div class="aspect-square bg-gray-50 overflow-hidden">
            @if($foto)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($foto->path_foto) }}"
                     alt="{{ $barang->nama_barang }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
            @else
                <div class="w-full h-full grid place-items-center text-4xl text-gray-200">👕</div>
            @endif
        </div>

        {{-- Badge kondisi (atas kiri gambar) --}}
        <span class="absolute top-2 left-2 text-[10px] font-semibold text-gray-600 bg-white/90 rounded-full px-2.5 py-0.5 shadow-sm leading-tight">
            {{ $kondisiLabel }}
        </span>
    </a>

    {{-- Tombol favorit (atas kanan gambar) --}}
    @auth
        <form action="{{ url('/favorit/' . $barang->id_barang . '/toggle') }}" method="POST"
              class="absolute top-2 right-2">
            @csrf
            <button type="submit"
                    class="grid place-items-center w-8 h-8 rounded-full shadow transition
                           {{ $isFav ? 'bg-relove-500 text-white' : 'bg-white/90 text-gray-400 hover:text-relove-500' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     fill="{{ $isFav ? 'currentColor' : 'none' }}"
                     stroke="currentColor" stroke-width="2"
                     class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
            </button>
        </form>
    @endauth

    {{-- Info produk --}}
    <div class="p-3">
        <a href="{{ url('/barang/' . $barang->id_barang) }}" class="block">
            <h3 class="text-sm font-semibold text-gray-800 line-clamp-1 leading-snug">{{ $barang->nama_barang }}</h3>
            <p class="text-relove-600 font-bold text-sm mt-1">Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
        </a>

        <div class="flex items-center justify-between mt-1.5">
            {{-- Lokasi --}}
            @if($lokasi)
                <span class="flex items-center gap-0.5 text-[11px] text-gray-400 min-w-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-3 h-3 shrink-0 text-relove-300">
                        <path fill-rule="evenodd" d="M8 1.5a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9ZM2.5 6a5.5 5.5 0 1 1 7.766 4.998L13.25 14.5H2.75l2.984-3.502A5.507 5.507 0 0 1 2.5 6Z" clip-rule="evenodd"/>
                    </svg>
                    <span class="truncate">{{ $lokasi }}</span>
                </span>
            @else
                <span></span>
            @endif

            {{-- Rating --}}
            @if($rating)
                <span class="flex items-center gap-0.5 text-[11px] text-amber-500 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-3 h-3">
                        <path d="M8 1.25a.75.75 0 0 1 .673.418l1.42 2.877 3.174.461a.75.75 0 0 1 .416 1.28l-2.296 2.237.542 3.162a.75.75 0 0 1-1.088.79L8 10.747l-2.84 1.493a.75.75 0 0 1-1.088-.79l.542-3.162L2.317 6.05a.75.75 0 0 1 .416-1.28l3.174-.46 1.42-2.878A.75.75 0 0 1 8 1.25Z"/>
                    </svg>
                    <span class="font-medium text-gray-600">{{ number_format($rating, 1) }}</span>
                </span>
            @endif
        </div>
    </div>
</div>
