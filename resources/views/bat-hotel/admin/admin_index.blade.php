<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-light">

  <!-- navbar -->
  <nav class="navbar navbar-dark bg-dark px-4">
    <a href="{{ route('admin.dashboard') }}" class="navbar-brand fw-bold text-light">🏨 Admin Hotel</a>
    <div>
      <a href="{{ route('admin.kamar.index') }}" class="btn btn-warning text-dark me-2">Kelola Kamar</a>
      <form method="POST" action="{{ route('logout') }}" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
      </form>
    </div>
  </nav>

  <div class="container-fluid py-5 px-4">
    <h2 class="fw-bold mb-4 text-center">Daftar Transaksi</h2>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
      <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Nama User</th>
            <th>Jenis Kamar</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Status</th>
            <th>Bukti Bayar</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
          @forelse($transaksi as $index => $t)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $t->user->name ?? '-' }}</td>
            <td>{{ $t->kamar->jenis_kamar ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($t->tanggal_checkin)->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($t->tanggal_checkout)->format('d M Y') }}</td>

            <!-- STATUS -->
            <td>
              <span class="badge 
                @if($t->status == 'Menunggu Konfirmasi') bg-warning text-dark
                @elseif($t->status == 'Dikonfirmasi') bg-success 
                @elseif($t->status == 'Ditolak') bg-danger 
                @else bg-secondary @endif">
                {{ $t->status }}
              </span>
            </td>

            <!-- BUKTI PEMBAYARAN -->
            <td>
              @if($t->bukti_pembayaran)
                <a href="{{ asset('storage/' . $t->bukti_pembayaran) }}" class="btn btn-sm btn-primary" target="_blank">
                  <i class="fas fa-eye me-1"></i> Lihat Bukti
                </a>
              @else
                <span class="text-muted fst-italic">Belum diupload</span>
              @endif
            </td>

            <!-- AKSI tlk mnlk -->
            <td style="min-width: 250px;">
              @if($t->bukti_pembayaran || $t->status == 'Ditolak')
                <form action="{{ route('admin.transaksi.update', $t->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('PUT')
                  <select name="status" class="form-select form-select-sm d-inline w-auto">
                    <option value="Menunggu Konfirmasi" @selected($t->status == 'Menunggu Konfirmasi')>Menunggu</option>
                    <option value="Dikonfirmasi" @selected($t->status == 'Dikonfirmasi')>Dikonfirmasi</option>
                    <option value="Ditolak" @selected($t->status == 'Ditolak')>Ditolak</option>
                  </select>
                  <button type="submit" class="btn btn-sm btn-success">Ubah</button>
                </form>
              @else
                <span class="text-muted">Menunggu user upload...</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="text-center p-5">Belum ada transaksi.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
