<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Status Adopsi Saya | Pet Haven</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; }
    .status-badge {
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 0.9rem;
    }
    .status-pending { background: #ffeeba; color: #856404; }
    .status-approved { background: #c3e6cb; color: #155724; }
    .status-rejected { background: #f5c6cb; color: #721c24; }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="/home">🐾 Pet Haven</a>
      <div class="ms-auto">
        <a href="/home" class="btn btn-outline-dark me-2">Home</a>
        <div class="dropdown d-inline">
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
      </div>
    </div>
  </nav>

  <!-- Content -->
  <div class="container py-5">
    <h2 class="fw-bold mb-4 text-center">📋 Riwayat Pengajuan Adopsi</h2>

    @if($adoptions->isEmpty())
      <div class="alert alert-info text-center">
        Kamu belum mengajukan adopsi hewan 🐾
      </div>
    @else
      <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
          <thead class="table-dark">
            <tr>
              <th>No</th>
              <th>Nama Hewan</th>
              <th>Umur</th>
              <th>Tanggal Pengajuan</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($adoptions as $index => $adoption)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $adoption->pet->name ?? 'Tidak Ditemukan' }}</td>
              <td>{{ $adoption->pet->age ?? '-' }}</td>
              <td>{{ $adoption->created_at->format('d M Y') }}</td>
              <td>
                <span class="status-badge 
                  @if($adoption->status === 'pending') status-pending 
                  @elseif($adoption->status === 'approved') status-approved 
                  @else status-rejected @endif">
                  {{ ucfirst($adoption->status) }}
                </span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif

    <div class="alert alert-info text-center mt-4">
      Status pengajuan akan diperbarui oleh admin. Silakan cek secara berkala 🐾
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3">
    <p class="mb-0">© 2025 Pet Haven. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
