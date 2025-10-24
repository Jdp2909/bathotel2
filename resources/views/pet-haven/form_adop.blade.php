<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Adopsi | Pet Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .form-section {
      padding: 50px 0;
      background: #f8f9fa;
    }
    .form-card {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 5px 15px rgba(0,0,0,0.1);
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
    </div>
  </nav>

  <!-- Form Adopsi -->
  <section class="form-section">
    <div class="container">
      <div class="form-card">
        <h2 class="fw-bold mb-4 text-center">Formulir Adopsi Hewan</h2>
    @if(!Auth::check())
    <div class="alert alert-warning text-center">
    Anda harus <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">login</a> untuk mengisi formulir adopsi.
    </div>
    @else
      <form action="{{ route('adoption.store') }}" method="POST">
        @csrf
        
        <input type="hidden" name="pet_id" value="{{ $pet->id }}">

        <div class="mb-3">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" readonly required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" readonly required>
        </div>

        <div class="mb-3">
          <label class="form-label">Nomor Telepon</label>
          <input type="tel" name="phone"  maxlength="100" placeholder="Max 100 characters"  class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Alamat Lengkap</label>
          <textarea name="address" maxlength="100" placeholder="Max 100 characters"  class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Hewan yang Diadopsi</label>
          <input type="text" class="form-control" value="{{ $pet->name }}" disabled>
          <input type="hidden" name="pet_name" value="{{ $pet->name }}">
        </div>

        <div class="mb-3">
          <label class="form-label">Alasan Mengadopsi</label>
          <textarea name="reason" maxlength="100" placeholder="Max 100 characters" class="form-control" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-dark w-100">Kirim Permohonan</button>
      </form>
    @endif

    

      </div>
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
</body>
</html>
