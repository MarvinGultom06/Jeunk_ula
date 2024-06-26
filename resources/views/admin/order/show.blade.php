@extends('template.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Order Details</h1>

    @if(session('success'))
    <div class="bg-green-500 text-white p-4 mb-6">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded shadow overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-bold mb-4">Order ID: {{ $order->id }}</h2>
            <p class="mb-4"><strong>User:</strong> {{ $order->user->name }}</p>
            <p class="mb-4"><strong>Email:</strong> {{ $order->user->email }}</p>
            <p class="mb-4"><strong>Alamat:</strong> {{ $order->user->alamat }}</p>
            <p class="mb-4"><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
            <p class="mb-4"><strong>Payment Method:</strong> {{ $order->payment_method_id }}</p>
        </div>
        
        <table class="w-full bg-white rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">Product</th>
                    <th class="p-4 text-left">Price</th>
                    <th class="p-4 text-left">Quantity</th>
                    <th class="p-4 text-left">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td class="border-t p-4">
                        @if ($item->product)
                            {{ $item->product->name }}
                        @else
                            Product Not Found
                        @endif
                    </td>
                    <td class="border-t p-4">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="border-t p-4">{{ $item->quantity }}</td>
                    <td class="border-t p-4">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
