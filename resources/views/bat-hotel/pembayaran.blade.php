<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Konfirmasi Pesanan - Bat Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('home') }}">Bat Hotel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-warning text-white ms-2">
          <i class="fas fa-sign-out-alt me-1"></i> Logout
        </button>
      </form>
    </div>
  </div>
</nav>

<main class="container py-5" style="margin-top: 100px;">
  <div class="text-center mb-4">
    <h2 class="fw-bold text-dark">Langkah 1: Konfirmasi Pesanan Anda</h2>
    <p class="text-muted">Periksa detail pesanan Anda sebelum melanjutkan ke pembayaran.</p>
  </div>

  @if ($errors->any())
  <div class="alert alert-danger mx-auto mb-4" style="max-width: 800px;">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <div class="row justify-content-center g-4">
    <!-- Detail Pesanan -->
    <div class="col-lg-7">
      <div class="card shadow border-0 p-4">
        <h4 class="mb-3 border-bottom pb-2">Detail Booking</h4>
        <div class="row">
          <div class="col-md-5">
            <img src="{{ $kamar->gambar ? asset('storage/'.$kamar->gambar) : 'https://placehold.co/400x300/6c757d/white?text=Bat+Hotel' }}" 
                 alt="{{ $kamar->jenis_kamar }}" class="img-fluid rounded mb-3">
          </div>
          <div class="col-md-7">
            <h5>{{ $kamar->jenis_kamar }}</h5>
            <p class="text-muted">{{ $kamar->deskripsi ?? '-' }}</p>
            <ul class="list-unstyled">
              <li><i class="fas fa-users me-2 text-muted"></i> {{ $jumlah_tamu }} Tamu</li>
              <li><i class="fas fa-calendar-check me-2 text-muted"></i> <strong>Check-in:</strong> {{ $checkin->format('d M Y') }}</li>
              <li><i class="fas fa-calendar-times me-2 text-muted"></i> <strong>Check-out:</strong> {{ $checkout->format('d M Y') }}</li>
            </ul>
          </div>
        </div>
        <hr>
        <h5 class="mb-3">Rincian Harga</h5>
        <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Harga per Malam
            <span>Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Jumlah Malam
            <span>{{ $total_malam }} Malam</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
            <strong class="text-dark">Total Pembayaran</strong>
            <strong class="text-warning h5 mb-0">Rp {{ number_format($total_harga, 0, ',', '.') }}</strong>
          </li>
        </ul>
      </div>
    </div>

    <!-- Form Pembayaran -->
    <div class="col-lg-5">
      <div class="card shadow border-0 p-4">
        <h4 class="mb-3">Metode Pembayaran</h4>
        <form action="{{ route('pembayaran.store') }}" method="POST">
          @csrf
          <input type="hidden" name="kamar_id" value="{{ $kamar->id }}">
          <input type="hidden" name="tanggal_checkin" value="{{ $checkin->toDateString() }}">
          <input type="hidden" name="tanggal_checkout" value="{{ $checkout->toDateString() }}">
          <input type="hidden" name="jumlah_tamu" value="{{ $jumlah_tamu }}">

          <div class="mb-3">
            <label class="form-label fw-semibold">Pilih Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-select" required>
              <option value="">-- Pilih Metode --</option>
              <option value="Bank Transfer">Bank Transfer</option>

            </select>
          </div>

          <div class="alert alert-info small">
            <i class="fas fa-info-circle"></i> Anda akan diarahkan ke halaman upload bukti setelah mengkonfirmasi pesanan.
            Batas waktu pembayaran adalah <strong>1 jam</strong>.
          </div>

          <button type="submit" class="btn btn-warning w-100 text-white fw-semibold py-2">
            Konfirmasi & Pesan Sekarang
          </button>
        </form>
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
