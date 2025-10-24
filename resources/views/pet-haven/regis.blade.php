<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Pet Shop</title>
  <link rel="icon" href="foto/logo.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .register-container {
      max-width: 450px;
      margin: 60px auto;
      padding: 30px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .register-container h2 {
      font-weight: bold;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

  <div class="register-container">
    <h2 class="text-center">Daftar Akun</h2>

    <form method="POST" action="{{ route('register.post') }}">
      @csrf

      <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input id="name" name="name" type="text"
               value="{{ old('name') }}"
               class="form-control @error('name') is-invalid @enderror"
               placeholder="Masukkan nama lengkap" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="email"
               value="{{ old('email') }}"
               class="form-control @error('email') is-invalid @enderror"
               placeholder="Masukkan email" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Kata Sandi</label>
        <input id="password" name="password" type="password"
               class="form-control @error('password') is-invalid @enderror"
               placeholder="Masukkan kata sandi" required>
        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
        <input id="password_confirmation" name="password_confirmation" type="password"
               class="form-control"
               placeholder="Ulangi kata sandi" required>
      </div>

      <button type="submit" class="btn btn-dark w-100">Daftar</button>
    </form>

    <p class="text-center mt-3">
      Sudah punya akun? <a href="{{ route('login') }}">Login</a>
    </p>
  </div>

</body>
</html>
