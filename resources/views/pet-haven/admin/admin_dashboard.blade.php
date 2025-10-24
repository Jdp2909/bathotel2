<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | Kelola Adopsi Hewan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; }
    .status-badge {
      padding: 5px 10px; border-radius: 5px; font-size: 0.9rem;
    }
    .status-pending { background: #ffeeba; color: #856404; }
    .status-approved { background: #c3e6cb; color: #155724; }
    .status-rejected { background: #f5c6cb; color: #721c24; }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container d-flex justify-content-between">
      <a class="navbar-brand fw-bold" href="/admin/dashboard">🐾 Admin Panel</a>
      <a href="/admin/pets/control" class="btn btn-dark btn-md shadow-sm">Atur hewan </a>
      @auth
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
      @endauth


    </div>
  </nav>
  
  <div class="container py-5">
    <h2 class="fw-bold mb-4 text-center">Kelola Permohonan Adopsi</h2>
  <div class="text-end add-pet-btn">
      <a href="/admin/pets/create" class="btn btn-primary btn-md shadow-sm">
        ➕ Tambah Hewan
      </a>
        <a href="/admin/species/create" class="btn btn-primary btn-md shadow-sm">
        ➕ Tambah Spesies
      </a>
       <a href="/admin/breeds/create" class="btn btn-primary btn-md shadow-sm">
        ➕ Tambah keturunan
      </a>
        <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.adoptions.pdf') }}" class="btn btn-danger">
      <i class="bi bi-file-earmark-pdf"></i> Download PDF
    </a>
  </div>

  </div>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped text-center align-middle">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Telepon</th>
          <th>Alamat</th>
          <th>Hewan</th>
          <th>Alasan</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($adoptions as $index => $adoption)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $adoption->name }}</td>
          <td>{{ $adoption->email }}</td>
          <td>{{ $adoption->phone }}</td>
          <td>{{ $adoption->address }}</td>
          <td>{{ $adoption->pet->name ?? 'Tidak Ditemukan' }}</td>
          <td>{{ $adoption->reason }}</td>
          <td>
            <span class="status-badge 
              @if($adoption->status === 'pending') status-pending 
              @elseif($adoption->status === 'approved') status-approved 
              @else status-rejected @endif">
              {{ ucfirst($adoption->status) }}
            </span>
          </td>
          <td>
            @if($adoption->status === 'pending')
              <form action="{{ route('admin.adoptions.update', $adoption->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="approved">
                <button class="btn btn-success btn-sm">Setujui</button>
              </form>
              <form action="{{ route('admin.adoptions.update', $adoption->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="rejected">
                <button class="btn btn-danger btn-sm">Tolak</button>
              </form>
            @else
              <button class="btn btn-secondary btn-sm disabled">Sudah Diproses</button>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9">Belum ada permohonan adopsi.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <footer class="bg-dark text-light py-3 mt-5">
    <div class="container text-center">
      <small>© 2025 Pet Haven Admin Panel</small>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
