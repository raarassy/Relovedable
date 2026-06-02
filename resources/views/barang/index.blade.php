    <h1>Daftar Barang</h1>

    <a href="/barang/create">Tambah Barang</a>

    <hr>
    
@foreach($barangs as $barang)

    @if($barang->fotoBarangs->first())

        <img src="{{ asset('images/' . $barang->fotoBarangs->first()->path_foto) }}"
             width="200">

    @endif

    <h3>{{ $barang->nama_barang }}</h3>

    <p>{{ $barang->deskripsi }}</p>

    <p>Rp {{ $barang->harga }}</p>

    <p>{{ $barang->kategori }}</p>

    <a href="/barang/edit/{{ $barang->id_barang }}">
        Edit
    </a>

    |

    <a href="/barang/delete/{{ $barang->id_barang }}">
        Delete
    </a>

    <hr>

@endforeach