<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title}}</title>
</head>
<body>
    <a href="/product/create">tambah</a>
    <h1>{{ $title}}</h1>
    <table border="2">
        <tr>
            <th>Product Name</th>
            <th>Description</th>
            <th>category name</th>
            <th>Price</th>
            <th>Image</th>
        </tr>
        @foreach  ($products as $product)
        <tr>
            <td> {{ $product->name }}</td>
            <td> {{ $product->description }}</td>
            <td> {{ $product->category->name }}</td>
            <td> {{ $product->price  }}</td>
            <td><img src="{{ Storage::url($product->image)   }}" alt="" width="20%"></td>
            <td>
                <form action="/product/{{$product->id}}" method="POST" 
                onsubmit="return confirm('are you sure')">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
            <a href="/product/{{$product->id}}/edit">update</a>
            </td>   
        </tr>
        @endforeach
    </table>
</body>
</html>