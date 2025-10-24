<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Pencarian Kamar - Bat Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <style>
    .room-card { transition: all 0.3s ease; }
    .room-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.1) !important; }
    .room-price { font-size: 1.2rem; color: #333; }
    .room-amenities span { margin-right: 15px; color: #777; font-size: 0.9rem; }
  </style>
  <link rel="stylesheet" href="{{ asset('index.css') }}">
</head>
<body class="bg-light">

  <!-- navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
    <div class="container">
      <a class="navbar-brand logo fw-bold" href="{{ url('/') }}">Bat Hotel</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item"><a class="nav-link" href="{{ url('/#about') }}">Tentang Kami</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/#rooms') }}">Kamar</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/#testimonials') }}">Testimoni</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/#fasilitas') }}">Fasilitas</a></li>
          <a href="{{ url('/') }}" class="btn btn-outline-warning">Kembali ke Home</a>
          @auth
            <li class="nav-item dropdown ms-3">
              <button class="btn btn-warning text-white dropdown-toggle fw-semibold" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger fw-semibold">
                      <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                  </form>
                </li>
              </ul>
            </li>
          @else
            <li class="nav-item ms-3">
              <a class="btn btn-warning text-white px-3" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                <i class="fas fa-user me-1"></i> Login
              </a>
            </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

<section id="rooms" class="py-5" style="padding-top: 6rem !important;">
  <div class="container">

    <div class="alert alert-info shadow-sm mb-5">
      <h4 class="alert-heading">Pencarian Anda:</h4>
      <p class="mb-0">
        <i class="fas fa-calendar-check"></i> <strong>Check-in:</strong> {{ \Carbon\Carbon::parse($tgl_checkin_user)->format('d M Y') }}<br>
        <i class="fas fa-calendar-times"></i> <strong>Check-out:</strong> {{ \Carbon\Carbon::parse($tgl_checkout_user)->format('d M Y') }}<br>
        <i class="fas fa-users"></i> <strong>Jumlah Tamu:</strong> {{ $jumlah_tamu_user }} orang
      </p>
    </div>

    <h2 class="section-title text-center mb-4">Kamar yang Tersedia</h2>

    @if($kamarsTersedia->count() > 0)
      <div class="row">
        @foreach($kamarsTersedia as $kamar)
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card room-card h-100 shadow-sm border-0">
              <img src="{{ $kamar->gambar ? asset('storage/'.$kamar->gambar) : 'https://placehold.co/400x300/6c757d/white?text=Bat+Hotel' }}" 
                   class="card-img-top" alt="{{ $kamar->jenis_kamar }}" style="height: 250px; object-fit: cover;">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $kamar->jenis_kamar }}</h5>
                <p class="card-text text-muted">{{ $kamar->deskripsi ?? 'Kamar terbaik untuk Anda.' }}</p>
                <div class="room-amenities my-3">
                  <span><i class="fas fa-users"></i> {{ $kamar->maks_tamu }} Tamu</span>
                  <span><i class="fas fa-wifi"></i> WiFi</span>
                  <span><i class="fas fa-tv"></i> TV 4K</span>
                </div>
                <div class="mt-auto">
                  <p class="room-price"><strong>Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}</strong> / malam</p>
                  @auth
                    <a href="{{ route('pembayaran') }}?kamar_id={{ $kamar->id }}&tanggal_checkin={{ $tgl_checkin_user }}&tanggal_checkout={{ $tgl_checkout_user }}&jumlah_tamu={{ $jumlah_tamu_user }}" 
                       class="btn btn-warning w-100 fw-bold">Pesan Sekarang</a>
                  @else
                    <button type="button" class="btn btn-warning w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#loginModal">
                      Login untuk Memesan
                    </button>
                  @endauth
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="col-12 text-center">
        <div class="alert alert-warning" role="alert">
          <h4 class="alert-heading">Mohon Maaf!</h4>
          <p>Tidak ada kamar yang tersedia untuk tanggal dan jumlah tamu yang Anda pilih.</p>
          <hr>
          <a href="{{ url('/') }}" class="btn btn-outline-dark">Coba Cari Tanggal Lain</a>
        </div>
      </div>
    @endif

  </div>
</section>

<footer class="py-5 bg-dark text-white-50">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 mb-4">
        <h5 class="logo">Bat Hotels</h5>
        <p>Menyediakan akomodasi premium dengan sentuhan personal untuk perjalanan bisnis dan liburan Anda.</p>
      </div>
      <div class="col-lg-2 col-md-6 mb-4">
        <h5>Navigasi</h5>
        <ul class="list-unstyled footer-links">
          <li><a href="{{ url('/#about') }}" class="text-white-50 text-decoration-none">Tentang Kami</a></li>
          <li><a href="{{ url('/#rooms') }}" class="text-white-50 text-decoration-none">Kamar</a></li>
          <li><a href="{{ url('/#testimonials') }}" class="text-white-50 text-decoration-none">Testimoni</a></li>
          <li><a href="{{ url('/#fasilitas') }}" class="text-white-50 text-decoration-none">Fasilitas</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <h5>Kontak Kami</h5>
        <ul class="list-unstyled">
          <li><i class="fas fa-map-marker-alt me-2"></i>bat bat</li>
          <li><a href="tel:0211234567" class="text-white-50 text-decoration-none"><i class="fas fa-phone me-2"></i> (021) 123-4567</a></li>
          <li><a href="mailto:info@batHotels.com" class="text-white-50 text-decoration-none"><i class="fas fa-envelope me-2"></i> info@batHotels.com</a></li>
        </ul>
      </div>
      <div class="col-lg-3 mb-4">
        <h5>Ikuti Kami</h5>
        <div class="social-media">
          <a href="#" class="me-3 text-white"><i class="fab fa-instagram fa-2x"></i></a>
          <a href="#" class="me-3 text-white"><i class="fab fa-facebook-f fa-2x"></i></a>
          <a href="#" class="text-white"><i class="fab fa-twitter fa-2x"></i></a>
        </div>
      </div>
    </div>
    <hr class="text-white-50">
    <p class="text-center mb-0">&copy; 2025 Bat Hotel. All Rights Reserved.</p>
  </div>
</footer>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-4">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title fw-bold" id="loginModalLabel"><i class="fas fa-user-circle me-2"></i>Login untuk Melanjutkan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <form method="POST" action="{{ route('login.post') }}">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-warning w-100 text-white fw-semibold">Masuk</button>
        </form>
        <div class="text-center mt-3">
          <small>Belum punya akun? <a href="{{ route('register') }}" class="text-warning fw-semibold">Daftar Sekarang</a></small>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@if(session('error'))
<script>
  Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: "{{ session('error') }}",
    timer: 3000,
    showConfirmButton: false
  });
</script>
@endif
</body>
</html>
