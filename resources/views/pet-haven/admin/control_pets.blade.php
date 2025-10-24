<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | Kelola Hewan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; }
    img.pet-img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; }
    .action-btns button, .action-btns a { margin: 2px; }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container d-flex justify-content-between">
    <a class="navbar-brand fw-bold" href="/admin/dashboard">🐾 Admin Panel</a>
    @auth
    <div class="dropdown">
      <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
        {{ Auth::user()->name }}
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
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
  <h2 class="fw-bold mb-4 text-center">Kelola Hewan</h2>

  <div class="text-end mb-3">
      <a href="/admin/pets/create" class="btn btn-primary btn-md shadow-sm">➕ Tambah Hewan</a>
      <a href="/admin/species/create" class="btn btn-primary btn-md shadow-sm">➕ Tambah Spesies</a>
      <a href="/admin/breeds/create" class="btn btn-primary btn-md shadow-sm">➕ Tambah Keturunan</a>
  </div>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-bordered table-striped text-center align-middle">
    <thead class="table-dark">
      <tr>
        <th>No</th>
        <th>Gambar</th>
        <th>Nama</th>
        <th>Spesies</th>
        <th>Breed</th>
        <th>Umur</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($pets as $index => $pet)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>
          @if($pet->image)
            <img src="{{ asset('storage/' . $pet->image) }}" class="pet-img" alt="Pet Image">
          @else
            <span class="text-muted">Tidak ada</span>
          @endif
        </td>
        <td>{{ $pet->name }}</td>
        <td>{{ $pet->species->name ?? '—' }}</td>
        <td>{{ $pet->breed->name ?? '—' }}</td>
        <td>{{ $pet->age ?? '—' }}</td>
        <td>{{ $pet->description ?? '—' }}</td>
        <td class="action-btns">
          <a href="{{ route('pets.edit', $pet->id) }}" class="btn btn-warning btn-sm">✏️ Edit</a>
          <form action="{{ route('admin.pets.destroy', $pet->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus hewan ini?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">🗑 Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="8">Belum ada data hewan.</td>
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
