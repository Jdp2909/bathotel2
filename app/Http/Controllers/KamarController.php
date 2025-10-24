<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Transaksi; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class KamarController extends Controller
{
// admin

    // Tampilkan semua kamar (Admin)
    public function index(): View
    {
        $kamars = Kamar::all();
        return view('bat-hotel.admin.kamar', compact('kamars'));
    }

    // Tampilkan form tambah kamar (Admin)
    public function create(): View
    {
        return view('bat-hotel.admin.tambah_kamar');
    }

    // Simpan kamar baru (Admin)
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_kamar' => ['required', Rule::in(['Reguler', 'VIP', 'VVIP'])],
            'harga_per_malam' => 'required|integer|min:0',
            'maks_tamu' => 'required|integer|min:1|max:4',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('kamar', 'public');
        }

        Kamar::create($validated);

        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil ditambahkan!');
    }

    // Tampilkan form edit kamar (Admin)
    public function edit($id): View
    {
        $kamar = Kamar::findOrFail($id);
        return view('bat-hotel.admin.edit_kamar', compact('kamar'));
    }

    // Update kamar (Admin)
    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_kamar' => ['required', Rule::in(['Reguler', 'VIP', 'VVIP'])],
            'harga_per_malam' => 'required|integer|min:0',
            'maks_tamu' => 'required|integer|min:1|max:4',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $kamar = Kamar::findOrFail($id);

        if ($request->hasFile('gambar')) {
            if ($kamar->gambar) {
                Storage::disk('public')->delete($kamar->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('kamar', 'public');
        }

        $kamar->update($validated);

        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil diperbarui!');
    }

    // Hapus kamar (Admin)
    public function destroy($id): RedirectResponse
    {
        $kamar = Kamar::findOrFail($id);
        if ($kamar->gambar) {
            Storage::disk('public')->delete($kamar->gambar);
        }
        $kamar->delete();

        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil dihapus!');
    }

// user

// cari kamar yang tersedia
    public function search(Request $request): View|RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'tanggal_checkin' => 'required|date|after_or_equal:today',
            'tanggal_checkout' => 'required|date|after:tanggal_checkin',
            'jumlah_tamu' => 'required|integer|min:1|max:4',
        ], [
            'tanggal_checkin.after_or_equal' => 'Tanggal check-in tidak boleh tanggal yang sudah lewat.',
            'tanggal_checkout.after' => 'Tanggal check-out harus setelah tanggal check-in.',
        ]);

        if ($validator->fails()) {
            return redirect('/#rooms')
                    ->withErrors($validator)
                    ->withInput();
        }

        $tgl_checkin_user = $request->tanggal_checkin;
        $tgl_checkout_user = $request->tanggal_checkout;
        $jumlah_tamu_user = $request->jumlah_tamu;

        $kamarsTersedia = Kamar::where('maks_tamu', '>=', $jumlah_tamu_user)
            ->whereDoesntHave('transaksis', function ($query) use ($tgl_checkin_user, $tgl_checkout_user) {
                $query->where(function ($statusQuery) {
                        $statusQuery->where('status', 'Disetujui')
                                    ->orWhere(function ($subQuery) {
                                        $subQuery->where('status', 'Menunggu Konfirmasi')
                                                 ->where('created_at', '>=', now()->subHours(1));
                                    });
                    })
                    ->where(function ($dateQuery) use ($tgl_checkin_user, $tgl_checkout_user) {
                        $dateQuery->where('tanggal_checkin', '<', $tgl_checkout_user)
                                  ->where('tanggal_checkout', '>', $tgl_checkin_user);
                    });
            })
            ->get();

        return view('bat-hotel.hasil_pencarian', compact(
            'kamarsTersedia',
            'tgl_checkin_user',
            'tgl_checkout_user',
            'jumlah_tamu_user'
        ));
    }
}
