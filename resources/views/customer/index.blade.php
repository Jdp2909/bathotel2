<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title}}</title>
</head>
<body>
    <h1>{{ $title}}</h1>
    <a href="/customer/create">tambah</a>
    <table border="2">
        <tr>
            <th>customer Name</th>
            <th>Phone</th>
            <th>Address</th>
        </tr>
        @foreach  ($customers as $customer)
        <tr>
            <td> {{ $customer->name }}</td>
            <td> {{ $customer->phone }}</td>
            <td> {{ $customer->address }}</td>
            <td>
                <form action="/customer/{{$customer->id}}" method="POST" 
                onsubmit="return confirm('are you sure')">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
            <a href="/customer/{{$customer->id}}/edit">update</a>
            </td>   
        </tr>
        @endforeach
    </table>
    
</body>
</html>