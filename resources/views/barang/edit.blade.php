<h1>Edit Barang</h1>

<form action="/barang/update/{{ $barang->id_barang }}" method="POST">

    @csrf

    <input type="text"
           name="nama_barang"
           value="{{ $barang->nama_barang }}">

    <br><br>

    <textarea name="deskripsi">{{ $barang->deskripsi }}</textarea>

    <br><br>

    <input type="number"
           name="harga"
           value="{{ $barang->harga }}">

    <br><br>

    <input type="text"
           name="kategori"
           value="{{ $barang->kategori }}">

    <br><br>

    <button type="submit">Update</button>

</form>