<h1>Tambah Barang</h1>

<form action="/barang/store" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="text" name="nama_barang" placeholder="Nama Barang">
    <br><br>

    <textarea name="deskripsi" placeholder="Deskripsi"></textarea>
    <br><br>

    <input type="number" name="harga" placeholder="Harga">
    <br><br>

    <input type="text" name="kategori" placeholder="Kategori">
    <br><br>

    <input type="file" name="foto">
    <br><br>

    <button type="submit">Simpan</button>
</form>