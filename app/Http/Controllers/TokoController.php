<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Review;
use App\Models\Toko;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    // Profil toko publik
    public function show($id)
    {
        $toko = Toko::with(['user', 'barangs.fotoBarangs'])->findOrFail($id);
        $penjualId = $toko->id_user;

        $jumlahProduk = $toko->barangs->count();
        $jumlahPengikut = Follow::where('id_diikuti', $penjualId)->count();
        $ratingRata = Review::where('id_penjual', $penjualId)->avg('rating');
        $jumlahReview = Review::where('id_penjual', $penjualId)->count();

        $reviews = Review::with('pembeli')
            ->where('id_penjual', $penjualId)
            ->latest('id_review')
            ->take(10)
            ->get();

        $sedangDiikuti = auth()->check()
            ? Follow::where('id_pengikut', auth()->id())->where('id_diikuti', $penjualId)->exists()
            : false;

        $isOwner = auth()->check() && auth()->id() === $penjualId;

        // Transaksi selesai milik pembeli (yang login) dgn toko ini yg belum diulas
        // -> jadi pintu masuk tombol "Beri Ulasan" di halaman toko
        $transaksiBelumDiulas = null;
        if (auth()->check() && ! $isOwner) {
            $transaksiBelumDiulas = Transaksi::where('id_pembeli', auth()->id())
                ->where('id_penjual', $penjualId)
                ->where('status_transaksi', 'selesai')
                ->whereDoesntHave('review')
                ->latest('id_transaksi')
                ->first();
        }

        return view('toko.show', compact(
            'toko', 'jumlahProduk', 'jumlahPengikut', 'ratingRata',
            'jumlahReview', 'reviews', 'sedangDiikuti', 'isOwner',
            'transaksiBelumDiulas'
        ));
    }

    // Edit toko sendiri
    public function edit()
    {
        $toko = auth()->user()->toko;
        abort_unless($toko, 404);

        return view('toko.edit', compact('toko'));
    }

    public function update(Request $request)
    {
        $toko = auth()->user()->toko;
        abort_unless($toko, 404);

        $data = $request->validate([
            'nama_toko' => ['required', 'string', 'max:100'],
            'alamat_toko' => ['nullable', 'string', 'max:255'],
            'deskripsi_toko' => ['nullable', 'string'],
        ]);

        $toko->update($data);

        return redirect('/toko/' . $toko->id_toko)->with('success', 'Profil toko diperbarui.');
    }
}
