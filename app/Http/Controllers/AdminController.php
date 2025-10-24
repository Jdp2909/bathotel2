<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Transaksi;

class AdminController extends Controller
{
    // ===== KAMAR SECTION =====
    public function daftarKamar()
    {
        $kamar = Kamar::all();
        return view('admin.kamar.index', compact('kamar'));
    }

    public function tambahKamar(Request $request)
    {
        $request->validate([
            'nama_kamar' => 'required|string',
            'jenis_kamar' => 'required|string',
            'maks_tamu' => 'required|integer|min:1',
            'harga_per_malam' => 'required|integer|min:10000',
        ]);

        Kamar::create([
            'nama_kamar' => $request->nama_kamar,
            'jenis_kamar' => $request->jenis_kamar,
            'maks_tamu' => $request->maks_tamu,
            'harga_per_malam' => $request->harga_per_malam,
        ]);

        return back()->with('success', 'Kamar baru berhasil ditambahkan!');
    }

    public function hapusKamar($id)
    {
        Kamar::findOrFail($id)->delete();
        return back()->with('success', 'Kamar berhasil dihapus.');
    }

    // ===== TRANSAKSI SECTION =====
    public function daftarTransaksi()
    {
        $transaksi = Transaksi::with('user', 'kamar')->latest()->get();
        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function updateStatus($id, $status)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = $status;
        $transaksi->save();

        return back()->with('success', 'Status transaksi diperbarui menjadi: ' . ucfirst($status));
    }
}
