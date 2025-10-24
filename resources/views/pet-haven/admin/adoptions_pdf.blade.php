<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: 'DejaVu Sans', sans-serif;
      font-size: 12px;
      color: #333;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      border: 1px solid #666;
      padding: 8px;
      text-align: center;
    }
    th {
      background: #ddd;
    }
  </style>
</head>
<body>
  <h2>📋 Laporan Pengajuan Adopsi Pet Haven</h2>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Pemohon</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>Alamat</th>
        <th>Nama Hewan</th>
        <th>Alasan</th>
        <th>Status</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      @foreach($adoptions as $index => $adoption)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $adoption->name }}</td>
          <td>{{ $adoption->email }}</td>
          <td>{{ $adoption->phone }}</td>
          <td>{{ $adoption->address }}</td>
          <td>{{ $adoption->pet->name ?? '-' }}</td>
          <td>{{ $adoption->reason }}</td>
          <td>{{ ucfirst($adoption->status) }}</td>
          <td>{{ $adoption->created_at->format('d M Y') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <p style="margin-top: 20px; text-align: right;">
    Dicetak pada: {{ now()->format('d M Y, H:i') }}
  </p>
</body>
</html>
