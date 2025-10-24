<!DOCTYPE htal>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="Le=edge">
<title>{{ $title }}</title>
</head>
<body>
    <title>{{ $title }}</title>
    <form action="/customer/{{ $customer->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @if (session('success'))
    <div role="alert">
        <strong>Success!</strong>
        <span>{{ session('success')}}</span>
    </div>
        @endif
    <div>
        <label for="name">customer Name</label>
        <input type="text" name="name" id="name" value="{{ $customer->name}}" required>
    </div>

      <div>
        <label for="phone">phone Number</label>
        <textarea name="phone" id="phone"></textarea>
    </div>
    
    <div>
        <label for="address">Address</label>
        <textarea name="address" id="address"></textarea>
    </div>
    </div>
    <button type="submit">Edit customer</button>
    </form>
</body>
</html>