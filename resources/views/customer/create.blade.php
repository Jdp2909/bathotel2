<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>
    <title>{{ $title }}</title>

    <form action="/customer/create" method="post" enctype="multipart/form-data">
    @csrf

    @if(session('success'))
    <div role="alert">
        <strong>succes!</strong>
        <span> {{session('  success')}}</span>
    </div>
    @endif  

    <div>
        <label for="name">Customer Name</label>
        <input type="text" name="name" id="name" required>
    </div>

    <div>
        <label for="phone">phone Number</label>
        <textarea name="phone" id="phone"></textarea>
    </div>
    
    <div>
        <label for="address">Address</label>
        <textarea name="address" id="address"></textarea>
    </div>

    

    <button type="submit">Add Customer</button>
    </form>

</body>
</html>