<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Hewan | Pet Haven</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .form-section {
      padding: 50px 0;
      background: #f8f9fa;
    }
    .form-card {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 5px 15px rgba(0,0,0,0.1);
    }
    .current-image {
      max-width: 100px;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">🐾 Admin Panel</a>
    </div>
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
    @else
      <button class="btn btn-outline-dark me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
    @endauth
    @if(session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif
  </nav>
  
  <!-- Form Edit Hewan -->
  <section class="form-section">
    <div class="container">
      <div class="form-card">
        <h2 class="fw-bold mb-4 text-center">Edit Hewan</h2>
        <form action="{{ route('pets.update', $pet->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="form-group mb-3">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $pet->name }}" required>
          </div>

          <div class="form-group mb-3">
            <label for="species_id">Species</label>
            <select name="species_id" class="form-control" required>
              <option value="" disabled>-- Select Species --</option>
              @foreach($species as $s)
                <option value="{{ $s->id }}" {{ $pet->species_id == $s->id ? 'selected' : '' }}>
                  {{ $s->name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="form-group mb-3">
            <label for="breed_id">Breed</label>
            <select name="breed_id" class="form-control">
              <option value="" disabled>-- Select Breed --</option>
              @foreach($breeds as $b)
                <option value="{{ $b->id }}" {{ $pet->breed_id == $b->id ? 'selected' : '' }}>
                  {{ $b->name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="form-group mb-3">
            <label for="age">Age</label>
            <input type="number" name="age" class="form-control" value="{{ $pet->age }}">
          </div>

          <div class="form-group mb-3">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control">
            @if($pet->image)
              <img src="{{ asset('storage/' . $pet->image) }}" alt="Current Image" class="current-image">
            @endif
          </div>

          <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control">{{ $pet->description }}</textarea>
          </div>

          <button type="submit" class="btn btn-primary">Update Pet</button>
        </form>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
