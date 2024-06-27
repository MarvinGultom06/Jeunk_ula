@extends('template.main')

@section('content')
<div class="flex-1 p-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <img src="product-detail.jpg" alt="Product Detail" class="h-96 w-full object-cover mb-4 rounded-lg">
        <h1 class="text-4xl font-bold mb-4 text-primary">Product Name</h1>
        <p class="text-gray-700 mb-4">Detailed description of the product. This includes all the necessary details that a customer would like to know about the product.</p>
        <p class="text-2xl font-bold mb-4">$99.99</p>
        <button class="bg-primary text-white px-4 py-2 rounded-lg">Add to Cart</button>
    </div>
</div>
@endsection