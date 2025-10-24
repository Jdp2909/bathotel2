<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\Kamar;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    // konfirmasi pesanan
    public function create(Request $request)
    {
        $request->validate([
            'kamar_id' => 'required|exists:kamar,id',
            'tanggal_checkin' => 'required|date',
            'tanggal_checkout' => 'required|date|after:tanggal_checkin',
            'jumlah_tamu' => 'required|integer|min:1',
        ]);

        $kamar = Kamar::findOrFail($request->kamar_id);
        $checkin = Carbon::parse($request->tanggal_checkin);
        $checkout = Carbon::parse($request->tanggal_checkout);
        $jumlah_tamu = $request->jumlah_tamu;

        $total_malam = $checkin->diffInDays($checkout);
        $total_harga = $kamar->harga_per_malam * $total_malam;

        return view('bat-hotel.pembayaran', compact(
            'kamar', 'checkin', 'checkout', 'jumlah_tamu', 'total_malam', 'total_harga'
        ));
    }

//   simpan booking
    public function store(Request $request)
    {
        $request->validate([
            'kamar_id' => 'required|exists:kamar,id',
            'tanggal_checkin' => 'required|date',
            'tanggal_checkout' => 'required|date|after_or_equal:tanggal_checkin',
            'jumlah_tamu' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|in:Bank Transfer,QRIS',
        ]);

        $kamar_id = $request->kamar_id;
        $tgl_checkin = $request->tanggal_checkin;
        $tgl_checkout = $request->tanggal_checkout;

        $adaBookingKonflik = Transaksi::where('kamar_id', $kamar_id)
            ->where(function ($query) {
                $query->where('status', 'Dikonfirmasi')
                      ->orWhere(function ($subQuery) {
                          $subQuery->where('status', 'Menunggu Konfirmasi')
                                   ->where('created_at', '>=', now()->subHours(1));
                      });
            })
            ->where(function ($q) use ($tgl_checkin, $tgl_checkout) {
                $q->where('tanggal_checkin', '<', $tgl_checkout)
                  ->where('tanggal_checkout', '>', $tgl_checkin);
            })
            ->exists();

        if ($adaBookingKonflik) {
            return redirect()->route('kamar.search', $request->only(['tanggal_checkin', 'tanggal_checkout', 'jumlah_tamu']))
                             ->with('error', 'Maaf! Kamar ini baru saja dipesan orang lain. Silakan pilih kamar lain.');
        }

        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'kamar_id' => $request->kamar_id,
            'tanggal_checkin' => $request->tanggal_checkin,
            'tanggal_checkout' => $request->tanggal_checkout,
            'jumlah_tamu' => $request->jumlah_tamu,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bukti_pembayaran' => null,
            'status' => 'Menunggu Konfirmasi',
        ]);

        return redirect()->route('transaksi.pembayaran', ['id' => $transaksi->id])
                         ->with('success', 'Booking berhasil! Segera lakukan pembayaran dalam 1 jam.');
    }

//    halaman upload bukti pembayaran
    public function showPembayaran($id)
    {
        $transaksi = Transaksi::with('kamar')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($transaksi->status != 'Menunggu Konfirmasi') {
            return redirect()->route('dashboard')->with('info', 'Transaksi ini sudah diproses atau dibatalkan.');
        }

        if ($transaksi->created_at < now()->subHours(1)) {
            return redirect()->route('dashboard')->with('error', 'Waktu pembayaran Anda telah habis. Silakan lakukan booking ulang.');
        }

        $checkin = Carbon::parse($transaksi->tanggal_checkin);
        $checkout = Carbon::parse($transaksi->tanggal_checkout);
        $total_malam = $checkin->diffInDays($checkout);
        $total_harga = $transaksi->kamar->harga_per_malam * $total_malam;

        return view('bat-hotel.pembayaran_upload', compact('transaksi', 'total_malam', 'total_harga'));
    }

//  bukti pembayaran
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $transaksi = Transaksi::with('kamar')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($transaksi->status != 'Menunggu Konfirmasi') {
            return redirect()->route('dashboard')->with('info', 'Transaksi ini sudah diproses.');
        }

        if ($transaksi->bukti_pembayaran) {
            Storage::disk('public')->delete($transaksi->bukti_pembayaran);
        }

        $path = $request->file('bukti_pembayaran')->store('bukti', 'public');

        $transaksi->update([
            'bukti_pembayaran' => $path
        ]);

        return redirect()->route('dashboard')
                         ->with('success', 'Bukti pembayaran berhasil diupload. Mohon tunggu konfirmasi Admin.');
    }

//    riwayat transakksi user
    public function riwayat()
    {
        $transaksis = Transaksi::with('kamar')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($transaksis as $transaksi) {
            $checkin = Carbon::parse($transaksi->tanggal_checkin);
            $checkout = Carbon::parse($transaksi->tanggal_checkout);
            $total_malam = $checkin->diffInDays($checkout);
            $transaksi->total_harga = $transaksi->kamar->harga_per_malam * $total_malam;
        }

        return view('bat-hotel.riwayat', compact('transaksis'));
    }
// admin
    public function index()
    {
        $transaksi = Transaksi::with('user', 'kamar')->orderBy('created_at', 'desc')->get();
        return view('bat-hotel.admin.admin_index', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Konfirmasi,Dikonfirmasi,Ditolak'
        ]);

        $transaksi = Transaksi::findOrFail($id);

        // jika booking ditolak
        if ($request->status == 'Ditolak') {
        }

        //  jika dikonfirmasi
        if ($request->status == 'Dikonfirmasi') {
        }

        $transaksi->status = $request->status;
        $transaksi->save();

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
