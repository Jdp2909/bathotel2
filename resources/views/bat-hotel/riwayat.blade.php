<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Transaksi - Bat Hotel</title>
  <link rel="icon" type="image/png" href="{{ asset('foto/logo.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
  <div class="container">
    <a class="navbar-brand logo fw-bold d-flex align-items-center" href="#">
            <img src="{{ asset('foto/logo.png') }}" alt="Logo" width="40" height="40" class="me-2">
            Bat Hotel
    </a>
    <div class="ms-auto d-flex align-items-center">
      <a href="{{ route('dashboard') }}" class="btn btn-outline-warning me-2">Home</a>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-warning text-white px-3">
          <i class="fas fa-sign-out-alt me-1"></i> Logout
        </button>
      </form>
    </div>
  </div>
</nav>

<main class="container py-5" style="margin-top: 100px;">
  <div class="text-center mb-4">
    <h2 class="fw-bold text-dark">Riwayat Transaksi Anda</h2>
    <p class="text-muted">Pantau semua proses booking Anda di sini.</p>
  </div>

  @foreach (['success', 'error', 'info'] as $msg)
    @if(session($msg))
      <div class="alert alert-{{ $msg == 'error' ? 'danger' : $msg }} mx-auto mb-4" style="max-width: 800px;">
        {{ session($msg) }}
      </div>
    @endif
  @endforeach

  <div class="card shadow border-0">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-nowrap">
          <thead class="table-dark">
            <tr>
              <th scope="col" class="ps-4">ID Booking</th>
              <th scope="col">Kamar</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Total Harga</th>
              <th scope="col">Status</th>
              <th scope="col" class="text-end pe-4">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($transaksis as $transaksi)
            <tr>
              <td class="ps-4 fw-bold">#{{ $transaksi->id }}</td>
              <td>
                <strong>{{ optional($transaksi->kamar)->jenis_kamar ?? '-' }}</strong><br>
                <small class="text-muted">{{ $transaksi->jumlah_tamu }} tamu</small>
              </td>
              <td>
                {{ \Carbon\Carbon::parse($transaksi->tanggal_checkin)->format('d M Y') }}
                <i class="fas fa-arrow-right mx-1"></i>
                {{ \Carbon\Carbon::parse($transaksi->tanggal_checkout)->format('d M Y') }}
              </td>
              <td class="fw-bold">
                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
              </td>
              <td>
                @php
                  $status = $transaksi->status;
                @endphp
                @if($status == 'Menunggu Konfirmasi')
                  <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                @elseif($status == 'Dikonfirmasi')
                  <span class="badge bg-success">Dikonfirmasi</span>
                @elseif($status == 'Ditolak')
                  <span class="badge bg-danger">Ditolak</span>
                @else
                  <span class="badge bg-secondary">{{ $status }}</span>
                @endif
              </td>
              <td class="text-end pe-4">
                @if($status == 'Menunggu Konfirmasi')
                  @if(is_null($transaksi->bukti_pembayaran))
                    <a href="{{ route('transaksi.pembayaran', $transaksi->id) }}" class="btn btn-sm btn-primary">
                      Bayar Sekarang
                    </a>
                  @else
                    <span class="text-muted fst-italic">Menunggu Dicek</span>
                  @endif
                @elseif($status == 'Dikonfirmasi')
                  <a href="#" class="btn btn-sm btn-outline-success disabled">
                    <i class="fas fa-check-circle"></i> Berhasil
                  </a>
                @elseif($status == 'Ditolak')
                  <span class="text-danger">Booking Ditolak</span>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center p-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Anda belum memiliki riwayat transaksi.</h5>
                <a href="{{ route('home') }}" class="btn btn-warning mt-3">Mulai Cari Kamar</a>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<footer class="bg-dark text-white text-center py-4 mt-5">
  <p class="mb-0">&copy; 2025 Bat Hotel. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
