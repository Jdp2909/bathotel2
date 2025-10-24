<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adopsi Hewan | Pet Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="foto/logo.png" type="image/x-icon">
  <style>
    .hero {
      padding: 50px 0;
      background: #f8f9fa;
      text-align: center;
    }
    .product-card {
      border: 1px solid #eee;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
      transition: transform 0.2s;
    }
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0px 5px 15px rgba(0,0,0,0.1);
    }
    .product-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="/home">🐾 Pet Haven</a>
      <div class="ms-auto">
        <a href="/home" class="btn btn-outline-dark me-2">Home</a>
        <a href="/riwayat" class="btn btn-outline-dark me-2">Riwayat</a>

      </div>
      @auth
          <!-- Dropdown kalau user  udh login -->
          <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
              {{ Auth::user()->name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item">Logout</button>
                </form>
              </li>
            </ul>
          </div>
        @else
          <!-- kalau user blum -->
          <button class="btn btn-outline-dark me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        @endauth
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <h1 class="fw-bold">Adopsi Hewan Kesayanganmu</h1>
      <p class="lead">Beri rumah baru untuk hewan yang membutuhkan kasih sayang.</p>
    </div>
  </section>

  <!-- Daftar Hewan Adopsi -->
  <section class="container my-5">
    <h2 class="fw-bold mb-4">Daftar Hewan untuk Diadopsi</h2>
  <div class="row g-4">
  @foreach($pets as $pet)
    <div class="col-md-3">
      <div class="product-card">
        @if($pet->image)
          <img src="{{ asset('storage/' . $pet->image) }}" class="product-img" alt="{{ $pet->name }}">
        @else
          <img src="{{ asset('foto/default.jpg') }}" class="product-img" alt="{{ $pet->name }}">
        @endif

        <h5 class="mt-2">{{ $pet->name }}</h5>
        <p>Spesies: {{ $pet->species->name ?? '-' }}</p>
        <p>Ras: {{ $pet->breed->name ?? '-' }}</p>

        <p>Umur: {{ $pet->age ?? '-' }} Tahun</p>

        <a href="{{ route('adoption.create', ['pet' => $pet->id]) }}" class="btn btn-dark">Adopsi Sekarang</a>
      </div>
    </div>
  @endforeach
</div>

  </section>

  <!-- Footer -->
  <footer class="bg-light py-4 mt-5">
    <div class="container text-center">
      <p class="mb-0">© 2025 Pet Haven | Semua Hak Dilindungi</p>
    </div>
  </footer>
<!-- Modal Login -->
  <div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content p-3">
        <h4 class="fw-bold mb-3">Login</h4>
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
          </div>
          <button type="submit" class="btn btn-dark w-100">Login</button>
        </form>
        <p class="text-center mt-3">
          Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
        </p>
      </div>
    </div>
  </div>

  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- ngasih tau status kek error atau berhasil dll -->

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @if(session('success'))
  <script>
      Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: `{{ session('success') }}`,
          showConfirmButton: false,
          timer: 2500
      });
  </script>
  @endif

  @if(session('error'))
  <script>
      Swal.fire({
          icon: 'error',
          title: 'Gagal!',
          text: `{{ session('error') }}`,
          showConfirmButton: false,
          timer: 2500
      });
  </script>
  @endif
</body>
</html>

</body>
</html>
