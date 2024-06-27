@extends('template.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-6 inline-block">Create Product</a>
    @if(session('success'))
    <div class="bg-green-500 text-white p-4 mb-6">
        {{ session('success') }}
    </div>
    @endif
    <table class="w-full bg-white rounded shadow">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-4 text-left">Image</th>
                <th class="p-4 text-left">Name</th>
                <th class="p-4 text-left">Price</th>
                <th class="p-4 text-left">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $product)
            <tr>
                <td class="border-t p-4">
                    <a href="{{ asset('images/' . $product->image) }}">
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="h-32 w-32 object-cover">
                    </a>
                </td>
                <td class="border-t p-4">{{ $product->name }}</td>
                <td class="border-t p-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="border-t p-4">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection