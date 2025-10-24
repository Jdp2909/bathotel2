<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>
    <title>{{ $title }}</title>

    <form action="/product/create" method="post" enctype="multipart/form-data">
    @csrf

    @if(session('success'))
    <div role="alert">
        <strong>succes!</strong>
        <span> {{session('  success')}}</span>
    </div>
    @endif  

    <div>
        <label for="name">Product Name</label>
        <input type="text" name="name" id="name" required>
    </div>

    <div>
        <label for="description">Product description</label>
        <textarea name="description" id="description"></textarea>
    </div>
    
    <div>
        <label for="category_id">Category Name</label>
        <select name="category_id" id="category_id" required>
            <option value="">select a category</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id}}"> {{$category->name}}</option>
            @endforeach
        </select>
    </div>

    
    <div>
        <label for="price">Price</label>
        <input type="number" name="price" id="price" required>
    </div>
    <div>
        <label for="image">image</label>
        <input type="file" name="image" id="image" required>
    </div>
    
    <button type="submit">Create Product</button>
    </form>

</body>
</html>