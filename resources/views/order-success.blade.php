@extends('template.main')

@section('content')
<div class="flex-1 p-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-4xl font-bold mb-8 text-primary">Order Successful!</h1>
        <p class="text-gray-700 mb-4">Thank you for your order. Your order has been successfully placed.</p>
        <p class="text-gray-700 mb-4">Order ID: {{ $order->id }}</p>
        <p class="text-gray-700 mb-4">Total Amount: Rp {{ number_format($order->total, 0, ',', '.') }}</p>
        <p class="text-gray-700 mb-4">Payment Method: {{ $order->payment_method }}</p>
        <a href="{{ route('home') }}" class="bg-primary text-white px-6 py-3 rounded-lg inline-block">Back to Home</a>
    </div>
</div>
@endsection