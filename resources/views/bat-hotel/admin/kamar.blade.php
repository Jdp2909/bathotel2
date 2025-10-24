<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | Kelola Kamar</title>
  <link rel="icon" type="image/png" href="{{ asset('foto/logo.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <!-- navbar -->
 <nav class="navbar navbar-dark bg-dark px-4">
    <a href="" class="navbar-brand fw-bold text-light">🏨 Admin Hotel</a>
    <div>
    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-warning">Kelola Transaksi</a>
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
      </form>
    </div>
  </nav>

  <div class="container py-5">
    <h2 class="fw-bold mb-4 text-center">Kelola Kamar</h2>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-end mb-3">
      <a href="{{ route('admin.kamar.create') }}" class="btn btn-primary">+ Tambah Kamar</a>
    </div>

    <table class="table table-bordered table-striped text-center align-middle">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Gambar</th>
          <th>Jenis Kamar</th>
          <th>Harga</th>
          <th>Maks Tamu</th>
          <th>Deskripsi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($kamars as $index => $kamar)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>
              @if($kamar->gambar)
                <img src="{{ asset('storage/'.$kamar->gambar) }}" width="100" class="rounded">
              @else
                <span class="text-muted">Tidak ada</span>
              @endif
            </td>
            <td>{{ $kamar->jenis_kamar }}</td>
            <td>Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}</td>
            <td>{{ $kamar->maks_tamu }}</td>
            <td>{{ $kamar->deskripsi ?? '-' }}</td>
            <td>
              <a href="{{ route('admin.kamar.edit', $kamar->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('admin.kamar.destroy', $kamar->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kamar ini?')">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7">Belum ada kamar.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

</body>
</html>
