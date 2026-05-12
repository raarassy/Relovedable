<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\FotoBarang;

class BarangController extends Controller
{
    // tampil semua barang
    public function index()
    {
        $barangs = Barang::all();

        return view('barang.index', compact('barangs'));
    }

    // tampil form tambah barang
    public function create()
    {
        return view('barang.create');
    }

    // simpan barang
    public function store(Request $request)
    {
        // simpan barang
        $barang = Barang::create([
            'id_penjual' => 1,
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'status' => 'tersedia',
        ]);

        // upload foto
        if ($request->hasFile('foto')) {

            $file = $request->file('foto');

            $namaFile = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('images'), $namaFile);

            // simpan ke tabel foto_barangs
            FotoBarang::create([
                'id_barang' => $barang->id_barang,
                'path_foto' => $namaFile,
            ]);
        }

        return redirect('/barang');
    }
        // form edit barang
    public function edit($id)
    {
        $barang = Barang::find($id);

        return view('barang.edit', compact('barang'));
    }

    // update barang
    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
        ]);

        return redirect('/barang');
    }

    // hapus barang
    public function delete($id)
    {
        $barang = Barang::find($id);

        $barang->delete();

        return redirect('/barang');
    }
}
