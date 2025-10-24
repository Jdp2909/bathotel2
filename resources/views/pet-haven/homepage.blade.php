<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pet Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="icon" href="foto/logo.png" type="image/x-icon">

  <style>
    .hero { padding: 50px 0; }
    .hero img { max-width: 100%; }
    .product-card, .testimonial-card {
      border: 1px solid #eee;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
      transition: transform 0.2s;
    }
    .product-img {
      width: 100%;       
      height: 200px;    
      object-fit: cover; 
      border-radius: 10px;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0px 5px 15px rgba(0,0,0,0.1);
    }
    .service-icon {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: #f5f5f5;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: auto;
      font-size: 30px;
    }
    .testimonial-card { background: #f8f9fa; }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="/home">🐾 Pet Haven</a>
      <div class="ms-auto">
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
  <section class="hero container text-center d-flex align-items-center justify-content-between">
    <div class="text-start">
      <h1 class="fw-bold">Tempat Terbaik <br> untuk Hewan Kesayanganmu</h1>
      <div class="mt-3">
        <a href="/adopsi" class="btn btn-dark">Adopsi Hewan</a>
      </div>
    </div>
    <div>
      <img src="foto/logo.png" alt="Pets">
    </div>
  </section>


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
