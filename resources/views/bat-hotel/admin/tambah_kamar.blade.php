<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Kamar Baru</title>
  <link rel="icon" type="image/png" href="{{ asset('foto/logo.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">
        
        <h2 class="fw-bold mb-4 text-center">Tambah Kamar Baru</h2>

        <form action="{{ route('admin.kamar.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 p-md-5 rounded shadow-sm border">
          @csrf

          <div class="mb-3">
            <label for="jenis_kamar" class="form-label fw-semibold">Jenis Kamar</label>
            <select class="form-select" id="jenis_kamar" name="jenis_kamar">
              <option value="" selected disabled>-- Pilih Jenis Kamar --</option>
              <option value="Reguler">Reguler</option>
              <option value="VIP">VIP</option>
              <option value="VVIP">VVIP</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="harga_per_malam" class="form-label fw-semibold">Harga per Malam</label>
            <div class="input-group">
              <span class="input-group-text">Rp</span>
              <input type="number" id="harga_per_malam" name="harga_per_malam" 
                     class="form-control" >
            </div>
          </div>

          <div class="mb-3">
            <label for="maks_tamu" class="form-label fw-semibold">Maksimal Tamu</label>
            <select class="form-select" id="maks_tamu" name="maks_tamu">
              <option value="1">1 orang</option>
              <option value="2" selected>2 orang</option> <option value="3">3 orang</option>
              <option value="4">4 orang</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="3" 
                      class="form-control" 
                      placeholder="Jelaskan fasilitas kamar..."></textarea>
          </div>

          <div class="mb-3">
            <label for="gambar" class="form-label fw-semibold">Gambar Kamar</label>
            <input type="file" id="gambar" name="gambar" class="form-control">
          </div>

          <hr class="my-4">

          <div class="text-end">
            <a href="{{ route('admin.kamar.index') }}" class="btn btn-secondary me-2">
              Batal
            </a>
            <button type="submit" class="btn btn-primary">
              Simpan Kamar
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>

</body>
</html>