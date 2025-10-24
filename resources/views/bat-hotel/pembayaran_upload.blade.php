<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Pembayaran - Bat Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('home') }}">Bat Hotel</a>
    <div class="ms-auto">
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
    <h2 class="fw-bold text-dark">Langkah 2: Upload Bukti Pembayaran</h2>
    <p class="text-muted">Booking Anda (ID: #{{ $transaksi->id }}) telah dibuat. Segera bayar dan upload bukti.</p>
  </div>

  @if(session('success'))
    <div class="alert alert-success mx-auto mb-4" style="max-width: 800px;">{{ session('success') }}</div>
  @endif
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
    <!-- Instruksi Pembayaran -->
    <div class="col-lg-6">
      <div class="card shadow border-0 p-4">
        <h4 class="mb-3 border-bottom pb-2">Instruksi Pembayaran</h4>
        <div class="alert alert-warning">
          <strong>Batas Waktu Pembayaran:</strong><br>
          {{ $transaksi->created_at->addHours(1)->format('d M Y, H:i') }} WIB
        </div>
        <p>Silakan lakukan transfer sejumlah:</p>
        <h3 class="text-dark fw-bold">Rp {{ number_format($total_harga, 0, ',', '.') }}</h3>
        <hr>

        @if($transaksi->metode_pembayaran == 'Bank Transfer')
          <h5 class="mb-3">Bank Transfer (Contoh)</h5>
          <p class="mb-1 fw-bold">Bank BCA</p>
          <p class="mb-3">No. Rek: <strong class="fs-5">123-456-7890</strong><br>A/N: PT Bat Hotel Indonesia</p>
          <p class="mb-1 fw-bold">Bank Mandiri</p>
          <p>No. Rek: <strong class="fs-5">098-765-4321</strong><br>A/N: PT Bat Hotel Indonesia</p>
        @elseif($transaksi->metode_pembayaran == 'QRIS')
          <h5 class="mb-3">QRIS</h5>
          <p>Silakan pindai kode QR di bawah ini menggunakan aplikasi e-wallet Anda.</p>
          <img src="https://placehold.co/300x300/eee/333?text=CONTOH+QRIS" alt="QRIS Code" class="img-fluid rounded mx-auto d-block">
        @endif
      </div>
    </div>

    <!-- Form Upload Bukti -->
    <div class="col-lg-6">
      <div class="card shadow border-0 p-4">
        <h4 class="mb-3">Upload Bukti</h4>
        <p>Setelah melakukan pembayaran, silakan unggah bukti transfer Anda di sini.</p>
        <form action="{{ route('transaksi.upload_bukti', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-4">
            <label class="form-label fw-semibold">Unggah Bukti Pembayaran (Gambar)</label>
            <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*" required>
            <small class="text-muted">Format: JPG, PNG, JPEG — max 5MB</small>
          </div>
          <button type="submit" class="btn btn-warning w-100 text-white fw-semibold py-2">
            <i class="fas fa-upload me-2"></i> Saya Sudah Bayar
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
