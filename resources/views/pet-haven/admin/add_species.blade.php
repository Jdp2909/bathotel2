<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Species | Pet Haven</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="card shadow-sm p-4 mx-auto" style="max-width: 500px;">
      <h3 class="fw-bold mb-3 text-center">Tambah Species Baru</h3>
      <form method="POST" action="{{ route('species.store') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Nama Species</label>
          <input type="text" name="name" class="form-control" placeholder="Contoh: Kucing" required>
        </div>
        <button class="btn btn-primary w-100">Tambah</button>
      </form>
    </div>
  </div>
</body>
</html>
