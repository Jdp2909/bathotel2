<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bat Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('index.css') }}">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand logo fw-bold" href="#">Bat Hotel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="#about">Tentang Kami</a></li>
                <li class="nav-item"><a class="nav-link" href="#testimonials">Testimoni</a></li>
                <li class="nav-item"><a class="nav-link" href="#fasilitas">Fasilitas</a></li>
                <a href="{{ url('/riwayat') }}" class="btn btn-outline-warning">Riwayat</a>
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

<section class="hero d-flex justify-content-center align-items-center position-relative overflow-hidden pt-5">
    <div class="hero-overlay"></div>
    <div class="container text-center position-relative z-2">
        <div class="hero-content" data-aos="fade-in" data-aos-duration="1200">
            <h1 class="display-3 text-shadow">Selamat Datang di Bat Hotel</h1>
            <p class="lead text-shadow">Nikmati kenyamanan dan pelayanan terbaik di jantung kota.</p>

            <div class="booking-form bg-light p-4 rounded-3 shadow-lg mt-4 mx-auto" style="max-width:900px;">
                <h3 class="mb-3" style="color:black;">Reservasi Kamar Anda</h3>

                @if ($errors->any())
                    <div class="alert alert-danger text-start" style="color:black;">
                        <h5 class="alert-heading fw-bold">Pencarian Gagal!</h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('kamar.search') }}" method="GET" class="row g-3 align-items-end" style="color:black;" id="bookingForm">
                    <div class="col-md-4">
                        <label for="checkin" class="form-label">Dari Tanggal</label>
                        <input type="date" id="checkin" name="tanggal_checkin" class="form-control" value="{{ old('tanggal_checkin') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="checkout" class="form-label">Hingga Tanggal</label>
                        <input type="date" id="checkout" name="tanggal_checkout" class="form-control" value="{{ old('tanggal_checkout') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="guests" class="form-label">Jumlah Tamu</label>
                        <select id="guests" name="jumlah_tamu" class="form-select">
                            <option value="1" >1 Tamu</option>
                            <option value="2" >2 Tamu</option>
                            <option value="3" >3 Tamu</option>
                            <option value="4">4 Tamu</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-warning w-100">Cek Ketersediaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('checkin').setAttribute('min', today);

            document.getElementById('checkin').addEventListener('change', function() {
                let checkinDate = this.value;
                if (checkinDate) {
                    let nextDay = new Date(checkinDate);
                    nextDay.setDate(nextDay.getDate() + 1);
                    document.getElementById('checkout').setAttribute('min', nextDay.toISOString().split('T')[0]);
                }
            });
        });
    </script>
</section>

<main>
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 loby" data-aos="fade-right">
                    <img src="{{ asset('foto/lobby1.jpg') }}" alt="Lobby Hotel" class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
                    <h2 class="section-title text-start">Pengalaman Menginap yang Tak Terlupakan</h2>
                    <p class="text-muted">Bat Hotel adalah oase ketenangan di tengah hiruk pikuk kota. Kami mendedikasikan diri untuk memberikan pelayanan personal dan fasilitas premium yang memastikan setiap momen Anda bersama kami menjadi istimewa.</p>
                    <ul class="list-unstyled mt-3">
                        <li><i class="fas fa-check-circle text-warning me-2"></i>Lokasi Strategis di Pusat Bisnis</li>
                        <li><i class="fas fa-check-circle text-warning me-2"></i>Desain Interior Modern & Elegan</li>
                        <li><i class="fas fa-check-circle text-warning me-2"></i>Sarapan Buffet Internasional</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

 

    <section id="testimonials" class="py-5">
        <div class="container">
            <h2 class="section-title text-center mb-5" data-aos="fade-up">Kata Mereka Tentang Kami</h2>
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="stars">★★★★★</div>
                        <p>"Pelayanan luar biasa! Kamarnya bersih dan pemandangannya indah. Pasti akan kembali lagi saat ke kota ini."</p>
                        <cite>– Budi Santoso</cite>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fasilitas" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center mb-5" data-aos="fade-up">Fasilitas Publik</h2>
            <div class="row g-3">
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                    <img src="{{ asset('foto/pool1.jpg') }}" class="img-fluid gallery-img" alt="Pool">
                </div>
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                    <img src="{{ asset('foto/pool1.jpg') }}" class="img-fluid gallery-img" alt="Pool">
                </div>
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                    <img src="{{ asset('foto/pool1.jpg') }}" class="img-fluid gallery-img" alt="Pool">
                </div>
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                    <img src="{{ asset('foto/pool1.jpg') }}" class="img-fluid gallery-img" alt="Pool">
                </div>
            </div>
        </div>
    </section>
</main>

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
                    <li><a href="#about" class="text-white-50">Tentang Kami</a></li>
                    <li><a href="#rooms" class="text-white-50">Kamar</a></li>
                    <li><a href="#testimonials" class="text-white-50">Testimoni</a></li>
                    <li><a href="#fasilitas" class="text-white-50">Galeri</a></li>
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
                    <a href="#" class="me-3"><i class="fab fa-instagram fa-2x"></i></a>
                    <a href="#" class="me-3"><i class="fab fa-facebook-f fa-2x"></i></a>
                    <a href="#"><i class="fab fa-twitter fa-2x"></i></a>
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
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800 });
</script>
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
