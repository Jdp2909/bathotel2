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
    <form action="/product/{{ $product->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @if (session('success'))
    <div role="alert">
        <strong>Success!</strong>
        <span>{{ session('success')}}</span>
    </div>
        @endif
    <div>
        <label for="name">Product Name</label>
        <input type="text" name="name" id="name" value="{{ $product->name}}" required>
    </div>

    <div>
        <label for="description">Product Description</label>
        <input type="text" name="description" id="description" value="{{ $product->description }}"
        requtred></textarea>
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
        <input type="number" name="price" id="price" value="{{ $product->price }}" required>
    </div>
        
    <div>
        <label for="image">Image</label>
        <input type="file" name="image" id="image">
        @if ($product->image)
        <div class="image-preview">
            <img src="{{ Storage:: url($product->image) }}" alt="Current Image">
            <p>Current Image</p>
        </div>
            @endif
    </div>
    <button type="submit">Edit Product</button>
    </form>
</body>
</html>