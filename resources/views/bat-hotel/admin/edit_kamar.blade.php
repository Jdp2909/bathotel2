<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Kamar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">
        
        <h2 class="fw-bold mb-4 text-center">Edit Kamar: {{ $kamar->jenis_kamar }}</h2>

        <form action="{{ route('admin.kamar.update', $kamar->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 p-md-5 rounded shadow-sm border">
          @csrf
          @method('PUT') <div class="mb-3">
            <label for="jenis_kamar" class="form-label fw-semibold">Jenis Kamar</label>
            <select class="form-select" id="jenis_kamar" name="jenis_kamar">
              <option value="Reguler" {{ $kamar->jenis_kamar == 'Reguler' ? 'selected' : '' }}>Reguler</option>
              <option value="VIP" {{ $kamar->jenis_kamar == 'VIP' ? 'selected' : '' }}>VIP</option>
              <option value="VVIP" {{ $kamar->jenis_kamar == 'VVIP' ? 'selected' : '' }}>VVIP</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="harga_per_malam" class="form-label fw-semibold">Harga per Malam</label>
            <div class="input-group">
              <span class="input-group-text">Rp</span>
              <input type="number" id="harga_per_malam" name="harga_per_malam" 
                     class="form-control" placeholder="Contoh: 500000" 
                     value="{{ $kamar->harga_per_malam }}">
            </div>
          </div>

          <div class="mb-3">
            <label for="maks_tamu" class="form-label fw-semibold">Maksimal Tamu</label>
            <select class="form-select" id="maks_tamu" name="maks_tamu">
              <option value="1" {{ $kamar->maks_tamu == 1 ? 'selected' : '' }}>1 orang</option>
              <option value="2" {{ $kamar->maks_tamu == 2 ? 'selected' : '' }}>2 orang</option>
              <option value="3" {{ $kamar->maks_tamu == 3 ? 'selected' : '' }}>3 orang</option>
              <option value="4" {{ $kamar->maks_tamu == 4 ? 'selected' : '' }}>4 orang</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="3" 
                      class="form-control" 
                      placeholder="Jelaskan fasilitas kamar...">{{ $kamar->deskripsi }}</textarea>
          </div>

          <div class="mb-3">
            <label for="gambar" class="form-label fw-semibold">Gambar Kamar</label>
            
            @if($kamar->gambar)
              <div class="mb-2">
                <img src="{{ asset('storage/' . $kamar->gambar) }}" alt="Gambar Kamar" class="img-thumbnail" width="200">
              </div>
            @endif
            
            <input type="file" id="gambar" name="gambar" class="form-control">
            <div class="form-text">Kosongkan jika tidak ingin mengganti gambar.</div>
          </div>

          <hr class="my-4">

          <div class="text-end">
            <a href="{{ route('admin.kamar.index') }}" class="btn btn-secondary me-2">
              Batal
            </a>
            <button type="submit" class="btn btn-primary">
              Update Kamar
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>

</body>
</html>