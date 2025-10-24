<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Status Adopsi Saya</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="home.html">🐾 Pet Haven</a>
      <div class="ms-auto">
        <a href="home.php" class="btn btn-outline-dark me-2">Home</a>
        <a href="adopsi.php" class="btn btn-dark">Adopsi</a>
      </div>
    </div>
  </nav>

  <!-- Konten -->
  <div class="container py-5">
    <h2 class="fw-bold mb-4 text-center">📋 Status Pengajuan Adopsi</h2>

    <div class="table-responsive">
      <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
          <tr>
            <th>Nama Hewan</th>
            <th>Jenis</th>
            <th>Umur</th>
            <th>Tanggal Pengajuan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Bella</td>
            <td>Kucing</td>
            <td>2 Tahun</td>
            <td>12 Sep 2025</td>
            <td><span class="badge bg-warning text-dark">Menunggu</span></td>
          </tr>
          <tr>
            <td>Max</td>
            <td>Anjing</td>
            <td>1 Tahun</td>
            <td>10 Sep 2025</td>
            <td><span class="badge bg-success">Disetujui</span></td>
          </tr>
          <tr>
            <td>Luna</td>
            <td>Kelinci</td>
            <td>6 Bulan</td>
            <td>08 Sep 2025</td>
            <td><span class="badge bg-danger">Ditolak</span></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="alert alert-info text-center mt-4">
      Status pengajuan akan diperbarui oleh admin. Silakan cek secara berkala 🐾
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3">
    <p class="mb-0">© 2025 Pet Haven. All rights reserved.</p>
  </footer>

</body>
</html>
