@extends('template.admin')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-2xl font-bold mb-6">Edit Product</h1>
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium">Name</label>
            <input type="text" id="name" name="name" value="{{ $product->name }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium">Description</label>
            <textarea id="description" name="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ $product->description }}</textarea>
        </div>
        <div class="mb-4">
            <label for="price" class="block text-sm font-medium">Price</label>
            <input type="text" id="price" name="price" value="{{ $product->price }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div class="mb-4">
            <label for="image" class="block text-sm font-medium">Image</label>
            <input type="file" id="image" name="image" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @if($product->image != 'noimage.jpg')
                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="h-32 w-32 object-cover rounded mt-4">
            @endif
        </div>
        <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg">Update Product</button>
    </form>
</div>
@endsection
