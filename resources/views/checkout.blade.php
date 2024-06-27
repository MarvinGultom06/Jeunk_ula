@extends('template.main')

@section('content')
<div class="flex-1 p-8">
    <h1 class="text-4xl font-bold mb-8 text-primary">Checkout</h1>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-primary">Order Summary</h2>
        <table class="w-full mb-8">
            <thead>
                <tr>
                    <th class="border-b-2 border-gray-200 p-4 text-left">Product</th>
                    <th class="border-b-2 border-gray-200 p-4 text-left">Price</th>
                    <th class="border-b-2 border-gray-200 p-4 text-left">Quantity</th>
                    <th class="border-b-2 border-gray-200 p-4 text-left">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td class="border-b border-gray-200 p-4">{{ $item['product']->name }}</td>
                    <td class="border-b border-gray-200 p-4">{{ number_format($item['product']->price, 0, ',', '.') }}</td>
                    <td class="border-b border-gray-200 p-4">{{ $item->quantity }}</td>
                    <td class="border-b border-gray-200 p-4">{{ number_format($item->quantity*$item['product']->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex justify-end mb-8">
            <p class="text-xl font-bold">Subtotal: {{ number_format($subtotal, 0, ',', '.') }}</p>
        </div>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="payment_method" class="block text-sm font-medium text-primary">Payment Method</label>
                <select id="payment_method" name="payment_method" class="mt-1 block w-full px-3 py-2 border border-primary rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <option value="GOPAY">GOPAY 08123456789</option>
                    <option value="DANA">DANA 08123456789</option>
                </select>
            </div>
            <input type="hidden" name="subtotal" value="{{ $subtotal }}">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg">Pay</button>
        </form>
    </div>
</div>
@endsection
